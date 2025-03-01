<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\WarehouseMaterial;
use Livewire\Component;

class OrderComponent extends Component
{
    public $orders, $order_id, $client_id, $status, $total, $clients, $products;
    public $orderItems = [];
    public $modalOpen = false, $editModalOpen = false, $viewModalOpen = false;
    public $selectedOrder;

    public function mount()
    {
        $this->loadOrders();
    }

    private function loadOrders()
    {
        $this->clients = Client::all();
        $this->products = Product::all();
        $this->orders = Order::with('client')->get();
    }

    public function addOrderItem()
    {
        $this->orderItems[] = ['product_id' => '', 'quantity' => 1];
    }

    public function saveOrder()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'orderItems' => 'required|array|min:1',
            'orderItems.*.product_id' => 'required|exists:products,id',
            'orderItems.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    preg_match('/orderItems\.(\d+)\.quantity/', $attribute, $matches);
                    $index = $matches[1] ?? null;

                    if ($index !== null && isset($this->orderItems[$index]['product_id'])) {
                        $productId = $this->orderItems[$index]['product_id'];
                        $stock = WarehouseMaterial::where('product_id', $productId)->where('type', 2)->sum('value');

                        if ($value > $stock) {
                            $fail("The quantity for selected product cannot exceed {$stock} in stock.");
                        }
                    }
                },
            ],
        ]);

        $order = Order::create([
            'client_id' => $this->client_id,
            'date' => now(),
            'total' => 0,
        ]);

        $total = 0;
        foreach ($this->orderItems as $item) {
            $product = Product::find($item['product_id']);
            $amount = $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'count' => $item['quantity'],
                'amount' => $amount,
            ]);

            $total += $amount;
        }

        $order->update(['total' => $total]);

        $this->loadOrders();
        $this->closeModal();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->addOrderItem();
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->editModalOpen = false;
        $this->viewModalOpen = false;
    }

    private function resetFields()
    {
        $this->order_id = null;
        $this->client_id = '';
        $this->status = '';
        $this->total = 0;
        $this->orderItems = [];
    }

    public function openViewModal($id)
    {
        $this->selectedOrder = Order::with('client')->findOrFail($id);
        $this->viewModalOpen = true;
    }

    public function openEditModal($orderId)
    {
        $order = Order::with('order_items')->findOrFail($orderId);

        $this->order_id = $order->id;
        $this->client_id = $order->client_id;
        $this->total = $order->total;
        $this->orderItems = $order->order_items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->count,
            ];
        })->toArray();

        $this->editModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->editModalOpen = false;
    }

    public function updateOrder()
    {
        $this->validate([
            'client_id' => 'required|exists:clients,id',
            'orderItems' => 'required|array|min:1',
            'orderItems.*.product_id' => 'required|exists:products,id',
            'orderItems.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    preg_match('/orderItems\.(\d+)\.quantity/', $attribute, $matches);
                    $index = $matches[1] ?? null;

                    if ($index !== null && isset($this->orderItems[$index]['product_id'])) {
                        $productId = $this->orderItems[$index]['product_id'];
                        $stock = WarehouseMaterial::where('product_id', $productId)->where('type', 2)->sum('value');

                        if ($value > $stock) {
                            $fail("The quantity for selected product cannot exceed {$stock} in stock.");
                        }
                    }
                },
            ],
        ]);

        $order = Order::findOrFail($this->order_id);
        $order->update([
            'client_id' => $this->client_id,
            'total' => 0,
        ]);

        OrderItem::where('order_id', $order->id)->delete();

        $total = 0;
        foreach ($this->orderItems as $item) {
            $product = Product::find($item['product_id']);
            $amount = $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'count' => $item['quantity'],
                'amount' => $amount,
            ]);

            $total += $amount;
        }

        $order->update(['total' => $total]);

        $this->loadOrders();
        $this->closeEditModal();
    }

    public function deleteOrder($id)
    {
        Order::findOrFail($id)->delete();
        $this->loadOrders();
    }

    public function render()
    {
        return view('sales-manager.orders.order-component', [
            'clients' => $this->clients,
            'products' => $this->products
        ]);
    }
}
