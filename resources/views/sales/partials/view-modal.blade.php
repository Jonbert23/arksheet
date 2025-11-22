<!-- View Sale Modal -->
<div class="modal fade" id="viewSaleModal" tabindex="-1" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content radius-12">
            <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">
                <div>
                    <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="viewSaleModalLabel">
                        Sale Details
                    </h5>
                    <p class="text-secondary-light mb-0" style="font-size: 13px;">Invoice: <span id="modalInvoiceNumber"></span></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-24 py-24" style="max-height: 70vh; overflow-y: auto;">
                <!-- Sale Details -->
                <div class="mb-20">
                    <h6 class="fw-bold mb-12" style="font-size: 16px; color: #ec3737;">Sale Information</h6>
                    <div class="p-16 bg-neutral-50 radius-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Date</p>
                                <p class="fw-semibold mb-0" id="modalSaleDate">-</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Customer</p>
                                <p class="fw-semibold mb-0" id="modalCustomer">-</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Sales Channel</p>
                                <p class="fw-semibold mb-0" id="modalChannel">-</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Method</p>
                                <p class="fw-semibold mb-0" id="modalPaymentMethod">-</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Status</p>
                                <p class="fw-semibold mb-0" id="modalPaymentStatus">-</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary-light mb-4" style="font-size: 12px;">Total Items</p>
                                <p class="fw-semibold mb-0" id="modalTotalItems">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="mb-20">
                    <h6 class="fw-bold mb-12" style="font-size: 16px; color: #ec3737;">Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th style="font-size: 13px;">Product</th>
                                    <th style="font-size: 13px;" class="text-center">Qty</th>
                                    <th style="font-size: 13px;" class="text-end">Price</th>
                                    <th style="font-size: 13px;" class="text-end">Tax</th>
                                    <th style="font-size: 13px;" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody id="modalSaleItems">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary -->
                <div class="p-20 radius-8" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border: 2px solid #ec3737;">
                    <div class="d-flex justify-content-between mb-8">
                        <span class="text-secondary-light">Subtotal:</span>
                        <span class="fw-semibold" id="modalSubtotal">{{ auth()->user()->business->currency }} 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-8" id="modalDiscountRow" style="display: none;">
                        <span class="text-secondary-light">Item Discounts:</span>
                        <span class="fw-semibold" style="color: #ec3737;" id="modalDiscount">{{ auth()->user()->business->currency }} 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-8">
                        <span class="text-secondary-light">Tax:</span>
                        <span class="fw-semibold" id="modalTax">{{ auth()->user()->business->currency }} 0.00</span>
                    </div>
                    <hr class="my-12" style="border-color: #ec3737; opacity: 0.3;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold" style="font-size: 18px;">Grand Total:</span>
                        <span class="fw-bold" style="font-size: 28px; color: #ec3737; letter-spacing: -0.5px;" id="modalTotal">{{ auth()->user()->business->currency }} 0.00</span>
                    </div>
                </div>

                <div id="modalNotes" class="mt-16" style="display: none;">
                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Notes:</p>
                    <p class="mb-0" id="modalNotesText"></p>
                </div>
            </div>
            <div class="modal-footer border-top py-20 px-24 bg-white d-flex justify-content-end gap-3">
                <button type="button" class="btn d-flex align-items-center justify-content-center gap-2 radius-8 py-12 px-20" 
                        style="background: #f8f9fa; color: #495057; border: 1px solid #dee2e6; font-weight: 600;"
                        data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i>
                    <span>Close</span>
                </button>
                <a href="#" id="modalEditButton" class="btn d-flex align-items-center justify-content-center gap-2 radius-8 py-12 px-20" 
                   style="background: linear-gradient(135deg, #ec3737 0%, #c91c1c 100%); color: white; border: none; font-weight: 700; box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4); text-decoration: none;">
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Sale</span>
                </a>
            </div>
        </div>
    </div>
</div>

