<!-- Detailed Redemptions Table -->
<div class="table-responsive">
    @if($redemptions->count() > 0)
        <table class="table table-hover table-sm">
            <thead class="bg-light">
                <tr>
                    <th>{{ __('app.food_item') }}</th>
                    <th>{{ __('app.recipient') }}</th>
                    <th>{{ __('app.shop') }}</th>
                    <th>{{ __('app.amount_used') }}</th>
                    <th>{{ __('app.amount_owed') }}</th>
                    <th>{{ __('app.payment_status') }}</th>
                    <th>{{ __('app.redeemed_date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($redemptions as $redemption)
                    <tr>
                        <td>
                            <strong>{{ $redemption->foodListing->item_name ?? 'N/A' }}</strong>
                            @if($redemption->foodListing)
                                <br>
                                <small class="text-muted">{{ Str::limit($redemption->foodListing->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $redemption->recipient->name ?? 'N/A' }}
                            @if($redemption->recipient)
                                <br>
                                <small class="text-muted">{{ $redemption->recipient->email }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $redemption->shop->name ?? 'N/A' }}
                            @if($redemption->shop && $redemption->shop->shopProfile)
                                <br>
                                <small class="text-muted">{{ $redemption->shop->shopProfile->shop_name ?? '' }}</small>
                            @endif
                        </td>
                        <td>
                            <strong>£{{ number_format($redemption->amount_used, 2) }}</strong>
                        </td>
                        <td>
                            £{{ number_format($redemption->amount_owed_at_shop, 2) }}
                        </td>
                        <td>
                            @if($redemption->payment_collected)
                                <span class="badge badge-success">{{ __('app.collected') }}</span>
                            @else
                                <span class="badge badge-warning">{{ __('app.pending') }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $redemption->redeemed_at ? $redemption->redeemed_at->format('d M Y H:i') : 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> {{ __('app.no_redemptions_found') }}
        </div>
    @endif
</div>
