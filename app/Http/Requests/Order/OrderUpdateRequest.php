<?php

namespace App\Http\Requests\Order;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property bool $validated
 * @property bool $sent
 * @property bool $received
 * @property PaymentMode $payment_mode
 * @property PaymentStatus $payment_status
 */
#[OA\Schema(
    schema: 'OrderUpdateInput',
    required: ['customer_id', 'store_id'],
    properties: [
        new OA\Property(property: 'validated', description: 'Is the order validated?', type: 'boolean', nullable: false),
        new OA\Property(property: 'sent', description: 'Is the order sent?', type: 'boolean', nullable: false),
        new OA\Property(property: 'received', description: 'Is the order received?', type: 'boolean', nullable: false),
        new OA\Property(
            property: 'payment_status',
            description: 'The payment status of the order',
            type: 'string',
            enum: [PaymentStatus::AWAITING_PAYMENT, PaymentStatus::PROCESSING_PAYMENT, PaymentStatus::PAYMENT_ACCEPTED, PaymentStatus::PAYMENT_REJECTED],
            nullable: false
        ),
        new OA\Property(
            property: 'payment_mode',
            description: 'The payment mode of the order',
            type: 'string',
            enum: [PaymentMode::CASH, PaymentMode::STORE_CREDIT, PaymentMode::PAYPAL],
            nullable: true
        ),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for updating an order',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/OrderUpdateInput'),
    ]
)]
class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'validated' => 'required|boolean|accepted_if:sent,true',
            'sent' => 'required|boolean|accepted_if:received,true',
            'received' => 'required|boolean',
            'payment_mode' => 'present',
            'payment_status' => 'required',
        ];
    }
}
