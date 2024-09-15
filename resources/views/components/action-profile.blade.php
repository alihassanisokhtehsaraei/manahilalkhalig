<ul>
    <li><a href="{{ route('order.edit', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="Edit Inspection Order" data-original-title="Edit"><i data-feather="edit"></i></a></li>
    <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
    <li><a href="mailto:{{ $order->customer->email }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.email') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
    <li><a id="sweet-{id" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.delete') }}" data-original-title="Delete"><i data-feather="delete"></i></a></li>
</ul>
