<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        
        $query = Contact::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        
        $contacts = $query->latest()->paginate($perPage);
        
        return response()->json([
            'data' => $contacts->items(),
            'meta' => [
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'per_page' => $contacts->perPage(),
                'total' => $contacts->total(),
            ]
        ]);
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = Contact::validate($request->all());
            
            $contact = Contact::create($validated);
            
            return response()->json([
                'message' => 'İletişim formu başarıyla gönderildi.',
                'data' => $contact
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Doğrulama hatası',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact): JsonResponse
    {
        return response()->json([
            'data' => $contact
        ]);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        try {
            $validated = Contact::validate($request->all());
            
            $contact->update($validated);
            
            return response()->json([
                'message' => 'İletişim formu başarıyla güncellendi.',
                'data' => $contact->fresh()
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Doğrulama hatası',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Güncelleme sırasında bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $contact->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'İletişim formu başarıyla silindi.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Silme işlemi sırasında bir hata oluştu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get contact statistics
     */
    public function stats(): JsonResponse
    {
        $total = Contact::count();
        $today = Contact::whereDate('created_at', today())->count();
        $lastWeek = Contact::where('created_at', '>=', now()->subWeek())->count();
        
        return response()->json([
            'data' => [
                'total' => $total,
                'today' => $today,
                'last_week' => $lastWeek,
            ]
        ]);
    }
}
