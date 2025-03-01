@foreach ($product_ids as $key => $id)
    @php
        $product = \App\Models\Product::findOrFail($id);
    @endphp
    <tr>
        <td class="align-middle">
            <div class="from-group d-flex align-items-center">
                <div class="avatar avatar-sm">
                    <img class="rounded-circle" src="{{ uploadedAsset($product->thumbnail_image) }}" alt="avatar" />
                </div>
                <h6 class="fs-sm mb-0 ms-2">{{ $product->collectLocalization('name') }}
                </h6>
            </div>
        </td>
        <td class="align-middle">
            <span>{{ formatPrice($product->min_price) }}</span>
        </td>
        <td class="align-middle">
            <input type="number" lang="en" value="{{ isset($discount) ? $discount : $product->discount_value }}" min="0" step="0.001" class="form-control" required readonly>
            <input type="hidden" name="discount_{{ $id }}" value="{{ isset($discount) ? $discount : $product->discount_value }}">
        </td>
        <td class="align-middle">
            <select disabled class="form-control select2" data-toggle="select2" readonly>
                <option value="percent" {{ (isset($discount_type) ? $discount_type : $product->discount_type) == 'percent' ? 'selected' : '' }}>{{ localize('Percent %') }}</option>
                <option value="flat" {{ (isset($discount_type) ? $discount_type : $product->discount_type) == 'flat' ? 'selected' : '' }}>{{ localize('Fixed') }}</option>
            </select>
            <input type="hidden" name="discount_type_{{ $id }}" value="{{ isset($discount_type) ? $discount_type : $product->discount_type }}">
        </td>
    </tr>
@endforeach
