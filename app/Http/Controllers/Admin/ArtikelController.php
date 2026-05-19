<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArtikelController extends Controller
{
    public function index(): View
    {
        $artikels = Artikel::latest('created_at')->paginate(12);

        return view('admin.artikels.index', compact('artikels'));
    }

    public function create(): View
    {
        return view('admin.artikels.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:artikels,slug',
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kategori' => 'nullable|string|max:100',
            'waktu_baca' => 'nullable|integer|min:1',
            'penulis' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['judul']);
        }

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('artikels', 'public');
            $validated['gambar'] = $path;
        }

        Artikel::create($validated);

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Artikel $artikel): View
    {
        return view('admin.artikels.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('artikels', 'slug')->ignore($artikel->id)],
            'konten' => 'required|string',
            'ringkasan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'kategori' => 'nullable|string|max:100',
            'penulis' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateUniqueSlug($validated['judul'], $artikel->id);
        }

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('gambar')) {
            // delete old image if exists
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $path = $request->file('gambar')->store('artikels', 'public');
            $validated['gambar'] = $path;
        }

        $artikel->update($validated);

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel): RedirectResponse
    {
        $artikel->delete();

        return redirect()->route('admin.artikels.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Artikel::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
