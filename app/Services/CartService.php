<?php

namespace App\Services;

use App\Models\Menu;

class CartService
{
    private string $sessionKey = 'cart';

    public function getCart(): array
    {
        return session()->get($this->sessionKey, ['items' => []]);
    }

    public function addItem(Menu $menu, int $quantity = 1): void
    {
        $cart = $this->getCart();

        if (isset($cart['items'][$menu->id])) {
            $cart['items'][$menu->id]['quantity'] += $quantity;
        } else {
            $cart['items'][$menu->id] = [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => (float) $menu->price,
                'quantity' => max(1, $quantity),
                'note' => null,
            ];
        }

        if ($cart['items'][$menu->id]['quantity'] <= 0) {
            unset($cart['items'][$menu->id]);
        }

        session()->put($this->sessionKey, $cart);
    }

    public function updateQuantity(int $menuId, int $quantity): void
    {
        $cart = $this->getCart();

        if (!isset($cart['items'][$menuId])) {
            return;
        }

        if ($quantity <= 0) {
            unset($cart['items'][$menuId]);
        } else {
            $cart['items'][$menuId]['quantity'] = $quantity;
        }

        session()->put($this->sessionKey, $cart);
    }

    public function updateNote(int $menuId, string $note): void
    {
        $cart = $this->getCart();

        if (!isset($cart['items'][$menuId])) {
            return;
        }

        $cart['items'][$menuId]['note'] = trim($note) !== '' ? trim($note) : null;
        session()->put($this->sessionKey, $cart);
    }

    public function removeItem(int $menuId): void
    {
        $cart = $this->getCart();
        unset($cart['items'][$menuId]);
        session()->put($this->sessionKey, $cart);
    }

    public function clearCart(): void
    {
        session()->forget($this->sessionKey);
    }

    public function getTotal(): float
    {
        return collect($this->getCart()['items'] ?? [])
            ->sum(fn (array $item) => ((float) $item['price']) * ((int) $item['quantity']));
    }

    public function isEmpty(): bool
    {
        return empty($this->getCart()['items'] ?? []);
    }

    public function getDetailedItems()
    {
        $cartItems = collect($this->getCart()['items'] ?? []);

        if ($cartItems->isEmpty()) {
            return collect();
        }

        $menus = Menu::active()
            ->whereIn('id', $cartItems->pluck('menu_id'))
            ->get()
            ->keyBy('id');

        return $cartItems
            ->map(function (array $item) use ($menus) {
                return [
                    ...$item,
                    'menu' => $menus->get($item['menu_id']),
                    'subtotal' => ((float) $item['price']) * ((int) $item['quantity']),
                ];
            })
            ->values();
    }

    public function getItemCount(): int
    {
        return collect($this->getCart()['items'] ?? [])->sum('quantity');
    }
}
