<?php

namespace App\Http\Controllers\PurchaseInvoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovePurchaseInvoiceRequest;
use App\Http\Requests\PurchaseInvoice\CreatePurchaseInvoiceRequest;
use App\Http\Requests\PurchaseInvoice\UpdatePurchaseInvoiceRequest;
use App\Services\PurchaseInvoice\PurchaseInvoiceService;

class PurchaseInvoiceController extends Controller
{
    private $purchaseInvoiceService;
    public function __construct(PurchaseInvoiceService $purchaseInvoiceService)
    {
        $this->middleware("auth:admin");
        $this->purchaseInvoiceService = $purchaseInvoiceService;
    }
    public function index()
    {
        return $this->purchaseInvoiceService->getPurchaseInvoices(
            request()->page_size,
            request()->text,
            request()->store_id,
            request()->supplier_id,
        );
    }
    public function getStores()
    {
        return $this->purchaseInvoiceService->getStores();
    }
    public function getSuppliers()
    {
        return $this->purchaseInvoiceService->getSuppliers();
    }
    public function create(CreatePurchaseInvoiceRequest $request)
    {
        $user = $request->user();
        return $this->purchaseInvoiceService->create($user, $request->validated());
    }
    public function update(UpdatePurchaseInvoiceRequest $request)
    {
        $user = $request->user();
        return $this->purchaseInvoiceService->update($user, $request->validated());
    }
    public function approve(ApprovePurchaseInvoiceRequest $request)
    {
        return $this->purchaseInvoiceService->approve($request->user(), $request->validated());
    }
    public function delete($id)
    {
        $this->purchaseInvoiceService->delete($id);
    }
    public function getCurrentShift()
    {
        return $this->purchaseInvoiceService->getCurrentShift(request()->user());
    }
}
