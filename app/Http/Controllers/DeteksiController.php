<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DeteksiController extends Controller
{
    private array $penyakitList = [
        ['hasil' => 'Sehat',                    'penyakit' => null,                      'tingkat' => 'Ringan', 'akurasi' => [90, 98]],
        ['hasil' => 'Bercak Daun (Leaf Spot)',  'penyakit' => 'Cercospora capsici',      'tingkat' => 'Sedang', 'akurasi' => [80, 92]],
        ['hasil' => 'Keriting Daun (Leaf Curl)','penyakit' => 'Virus CMV',               'tingkat' => 'Sedang', 'akurasi' => [78, 90]],
        ['hasil' => 'Antraknosa',               'penyakit' => 'Colletotrichum acutatum', 'tingkat' => 'Berat',  'akurasi' => [85, 95]],
        ['hasil' => 'Layu Fusarium',            'penyakit' => 'Fusarium oxysporum',      'tingkat' => 'Berat',  'akurasi' => [82, 94]],
        ['hasil' => 'Bercak Bakteri',           'penyakit' => 'Xanthomonas campestris',  'tingkat' => 'Sedang', 'akurasi' => [76, 88]],
    ];

    private array $rekomendasiList = [
        'Sehat'                     => 'Tanaman Anda dalam kondisi sehat! Pertahankan perawatan rutin: penyiraman teratur, pemupukan setiap 2 minggu, dan pemeriksaan berkala.',
        'Bercak Daun (Leaf Spot)'  => 'Aplikasikan fungisida berbahan aktif mankozeb atau klorotalonil. Kurangi kelembaban dengan mengatur jarak tanam. Buang dan musnahkan daun yang terinfeksi.',
        'Keriting Daun (Leaf Curl)' => 'Kendalikan kutu daun (vektor virus) dengan insektisida sistemik. Cabut dan musnahkan tanaman yang terinfeksi parah. Gunakan mulsa untuk mencegah penyebaran.',
        'Antraknosa'                => 'Semprotkan fungisida berbahan aktif azoksistrobin atau mankozeb. Hindari luka mekanis saat panen. Perbaiki drainase lahan dan kurangi kelembaban.',
        'Layu Fusarium'             => 'Tidak ada obat efektif untuk tanaman terinfeksi parah. Cabut dan musnahkan. Sterilisasi tanah dengan solarisasi atau fumigasi. Gunakan varietas tahan penyakit.',
        'Bercak Bakteri'            => 'Semprot bakterisida berbahan aktif tembaga hidroksida. Hindari penyiraman dari atas. Rotasi tanaman dengan tanaman bukan famili Solanaceae.',
    ];

    public function index()
    {
        $lahans = Auth::user()->lahans()->get();
        return view('pages.deteksi', compact('lahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'lahan_id' => 'required|exists:lahans,id',
            'catatan'  => 'nullable|string|max:500',
        ], [
            'gambar.required' => 'Gambar wajib diunggah',
            'gambar.image'    => 'File harus berupa gambar',
            'gambar.mimes'    => 'Format gambar: JPG, JPEG, PNG, atau WEBP',
            'gambar.max'      => 'Ukuran gambar maksimal 5MB',
            'lahan_id.required' => 'Pilih lahan terlebih dahulu',
            'lahan_id.exists'   => 'Lahan tidak ditemukan',
        ]);

        // Validasi lahan milik user
        $lahan = Lahan::where('id', $request->lahan_id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $gambar  = $request->file('gambar');
        $aiBaseUrl = rtrim(config('app.ai_service_url', 'http://127.0.0.1:5000'), '/');

        $response = Http::acceptJson()
            ->timeout(120)
            ->attach(
                'file',
                file_get_contents($gambar->getRealPath()),
                $gambar->getClientOriginalName()
            )
            ->post($aiBaseUrl . '/predict');

        if (! $response->successful()) {
            throw ValidationException::withMessages([
                'gambar' => 'Layanan AI tidak merespons dengan benar. Silakan coba lagi.',
            ]);
        }

        $aiResult = $this->normalizeAiResponse($response->json());

        $namaFile = 'deteksi_' . Auth::id() . '_' . time() . '.' . $gambar->getClientOriginalExtension();
        $path = $gambar->storeAs('deteksi', $namaFile, 'public');
        $path = str_replace('\\', '/', $path);

        $deteksi = Deteksi::create([
            'user_id'           => Auth::id(),
            'lahan_id'          => $lahan->id,
            'gambar'            => $path,
            'hasil'             => $aiResult['hasil'],
            'penyakit'          => $aiResult['penyakit'],
            'tingkat_keparahan' => $aiResult['tingkat_keparahan'],
            'akurasi'           => $aiResult['akurasi'],
            'catatan'           => $request->catatan,
            'rekomendasi'       => $aiResult['rekomendasi'],
        ]);

        return redirect()->route('deteksi.show', $deteksi->id)->with('success', 'Deteksi berhasil!');
    }

    private function normalizeAiResponse(array $payload): array
    {
        $data = $payload['data'] ?? $payload['result'] ?? $payload;

        $hasilSource = $this->pickValue($data, ['hasil', 'label', 'prediction', 'predictions', 'class_name', 'kelas', 'class']);
        $hasil = $this->normalizeHasil($hasilSource);
        $fallback = $this->fallbackDiagnosis($hasil);

        return [
            'hasil' => $hasil,
            'penyakit' => $this->normalizeText($this->pickValue($data, ['penyakit', 'disease', 'label_detail']) ?? $fallback['penyakit']),
            'tingkat_keparahan' => $this->normalizeSeverity($this->pickValue($data, ['tingkat_keparahan', 'severity']) ?? $fallback['tingkat_keparahan']),
            'akurasi' => $this->normalizeAccuracy($this->pickValue($data, ['akurasi', 'confidence', 'probability', 'score']) ?? $fallback['akurasi']),
            'rekomendasi' => $this->normalizeText($this->pickValue($data, ['rekomendasi', 'recommendation', 'saran']) ?? $fallback['rekomendasi']),
        ];
    }

    private function fallbackDiagnosis(string $hasil): array
    {
        $defaultRekomendasi = 'Hasil deteksi sudah diterima. Silakan lanjutkan pemantauan dan sesuaikan perawatan tanaman berdasarkan gejala yang muncul.';

        if (array_key_exists($hasil, $this->rekomendasiList)) {
            $tingkat = 'Sedang';

            foreach ($this->penyakitList as $item) {
                if ($item['hasil'] === $hasil) {
                    $tingkat = $item['tingkat'];
                    break;
                }
            }

            return [
                'penyakit' => $hasil === 'Sehat' ? null : $hasil,
                'tingkat_keparahan' => $tingkat,
                'akurasi' => 0,
                'rekomendasi' => $this->rekomendasiList[$hasil],
            ];
        }

        return [
            'penyakit' => $hasil === 'Sehat' ? null : $hasil,
            'tingkat_keparahan' => $hasil === 'Sehat' ? 'Ringan' : 'Sedang',
            'akurasi' => 0,
            'rekomendasi' => $defaultRekomendasi,
        ];
    }

    private function normalizeHasil(mixed $value): string
    {
        if (is_array($value)) {
            $value = $this->pickValue($value, ['hasil', 'label', 'prediction', 'class_name', 'kelas', 'class', 'name'])
                ?? $this->firstScalar($value);
        }

        if (is_object($value)) {
            $value = $this->firstScalar((array) $value);
        }

        $hasil = trim((string) $value);

        if ($hasil === '') {
            return 'Sehat';
        }

        if (strcasecmp($hasil, 'sehat') === 0) {
            return 'Sehat';
        }

        return $hasil;
    }

    private function normalizeSeverity(mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            $value = $this->pickValue((array) $value, ['tingkat_keparahan', 'severity', 'level'])
                ?? $this->firstScalar((array) $value);
        }

        $severity = strtolower(trim((string) $value));

        return match ($severity) {
            'ringan', 'mild', 'low' => 'Ringan',
            'sedang', 'medium', 'moderate' => 'Sedang',
            'berat', 'high', 'severe' => 'Berat',
            default => 'Sedang',
        };
    }

    private function normalizeAccuracy(mixed $value): int
    {
        if (is_array($value) || is_object($value)) {
            $value = $this->pickValue((array) $value, ['akurasi', 'confidence', 'probability', 'score', 'value'])
                ?? $this->firstScalar((array) $value);
        }

        if ($value === null || $value === '') {
            return 0;
        }

        if (is_string($value)) {
            $value = str_replace('%', '', $value);
        }

        $accuracy = (float) $value;

        if ($accuracy <= 1) {
            $accuracy *= 100;
        }

        return max(0, min(100, (int) round($accuracy)));
    }

    private function normalizeText(mixed $value): ?string
    {
        if (is_array($value) || is_object($value)) {
            $value = $this->pickValue((array) $value, ['text', 'message', 'label', 'name'])
                ?? $this->firstScalar((array) $value);
        }

        $text = trim((string) $value);

        return $text === '' ? null : $text;
    }

    private function pickValue(array $source, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $source) && $source[$key] !== null && $source[$key] !== '') {
                return $source[$key];
            }
        }

        return null;
    }

    private function firstScalar(array $value): mixed
    {
        foreach ($value as $item) {
            if (is_array($item)) {
                $nested = $this->firstScalar($item);
                if ($nested !== null && $nested !== '') {
                    return $nested;
                }
                continue;
            }

            if (is_object($item)) {
                $nested = $this->firstScalar((array) $item);
                if ($nested !== null && $nested !== '') {
                    return $nested;
                }
                continue;
            }

            if ($item !== null && $item !== '') {
                return $item;
            }
        }

        return null;
    }

    public function show($id)
    {
        $deteksi = Deteksi::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->with('lahan')
                          ->firstOrFail();

        return view('pages.deteksi-hasil', compact('deteksi'));
    }

    public function image($id)
    {
        $deteksi = Deteksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (! $deteksi->gambar || ! Storage::disk('public')->exists($deteksi->gambar)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($deteksi->gambar));
    }
}
