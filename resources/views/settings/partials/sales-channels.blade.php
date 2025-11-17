<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Sales Channels</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addChannelModal">
        <iconify-icon icon="ic:round-plus" class="icon text-xl"></iconify-icon>
        Add Channel
    </button>
</div>

<div id="channelsList">
    @forelse($salesChannels as $channel)
    <div class="config-item {{$channel->is_active?'':'inactive'}}">
        <div class="d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <h6 class="text-md mb-1">{{$channel->name}}</h6>
                @if($channel->description)<p class="text-sm text-secondary-light mb-0">{{$channel->description}}</p>@endif
            </div>
            <div class="d-flex gap-2">
                <span class="badge {{$channel->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$channel->is_active?'Active':'Inactive'}}</span>
                <button class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-channel" data-id="{{$channel->id}}" data-name="{{$channel->name}}" data-description="{{$channel->description}}" data-active="{{$channel->is_active}}" title="Edit"><iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon></button>
                <button class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-channel" data-id="{{$channel->id}}" title="Delete"><iconify-icon icon="mingcute:delete-2-line" class="text-lg"></iconify-icon></button>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div class="d-flex justify-content-center mb-3">
            <iconify-icon icon="mdi:store" class="text-secondary-light" style="font-size: 48px;"></iconify-icon>
        </div>
        <p class="text-secondary-light mb-0">No sales channels configured</p>
    </div>
    @endforelse
</div>

<!-- Modals here - similar structure to product categories -->

