<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index(): View
    {
        return view('public.cart', [
            'cartItems' => $this->cartService->getDetailedItems(),
            'cartTotal' => $this->cartService->getTotal(),
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'exists:menus,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $menu = Menu::active()->findOrFail($validated['menu_id']);
        $this->cartService->addItem($menu, $validated['quantity'] ?? 1);

        return response()->json($this->buildResponse('Item added to cart.'));
    }

    public function updateQuantity(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
        ]);

        $this->cartService->updateQuantity($validated['menu_id'], $validated['quantity']);

        return response()->json($this->buildResponse('Cart quantity updated.'));
    }

    public function updateNote(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'integer'],
            'note' => ['nullable', 'string'],
        ]);

        $this->cartService->updateNote($validated['menu_id'], $validated['note'] ?? '');

        return response()->json($this->buildResponse('Item note updated.'));
    }

    public function remove(int $menuId): JsonResponse
    {
        $this->cartService->removeItem($menuId);

        return response()->json($this->buildResponse('Item removed from cart.'));
    }

    private function buildResponse(string $message): array
    {
        return [
            'message' => $message,
            'cart' => $this->cartService->getCart(),
            'count' => $this->cartService->getItemCount(),
            'total' => $this->cartService->getTotal(),
        ];
    }
}
