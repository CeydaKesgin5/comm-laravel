<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    /**
     * Tüm sponsorları listeler
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sponsors = Sponsor::all();
        return response()->json([
            'success' => true,
            'data' => $sponsors
        ]);
    }

    /**
     * Yeni bir sponsor oluşturur
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sponsorship_type' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $data = [
            'name' => $validated['name'],
            'sponsorship_type' => $validated['sponsorship_type'],
        ];

        // Resim yükleme işlemi
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/sponsors');
            $data['image_url'] = Storage::url($path);
        }

        $sponsor = Sponsor::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Sponsor başarıyla oluşturuldu',
            'data' => $sponsor
        ], 201);
    }

    /**
     * Belirtilen sponsoru getirir
     *
     * @param  Sponsor  $sponsor
     * @return JsonResponse
     */
    public function show(Sponsor $sponsor): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $sponsor
        ]);
    }

    /**
     * Belirtilen sponsoru günceller
     *
     * @param  Request  $request
     * @param  Sponsor  $sponsor
     * @return JsonResponse
     */
    public function update(Request $request, Sponsor $sponsor): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'sponsorship_type' => 'sometimes|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [];
        if (isset($validated['name'])) {
            $data['name'] = $validated['name'];
        }
        if (isset($validated['sponsorship_type'])) {
            $data['sponsorship_type'] = $validated['sponsorship_type'];
        }

        // Yeni resim yüklendiyse
        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($sponsor->image_url) {
                $oldImage = str_replace('/storage', 'public', $sponsor->image_url);
                Storage::delete($oldImage);
            }
            
            // Yeni resmi yükle
            $path = $request->file('image')->store('public/sponsors');
            $data['image_url'] = Storage::url($path);
        }

        $sponsor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sponsor başarıyla güncellendi',
            'data' => $sponsor->fresh()
        ]);
    }

    /**
     * Belirtilen sponsoru siler
     *
     * @param  Sponsor  $sponsor
     * @return JsonResponse
     */
    public function destroy(Sponsor $sponsor): JsonResponse
    {
        // İlişkili resmi sil
        if ($sponsor->image_url) {
            $imagePath = str_replace('/storage', 'public', $sponsor->image_url);
            Storage::delete($imagePath);
        }

        $sponsor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sponsor başarıyla silindi'
        ]);
    }
}
