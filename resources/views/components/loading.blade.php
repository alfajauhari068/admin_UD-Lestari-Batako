@props(['id' => 'table-loading'])

<div id="{{ $id }}" class="table-loading-overlay" style="display:none;">
    <div class="table-loading-inner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-2 small text-muted">Loading...</div>
    </div>
</div>

<style>
    .table-loading-overlay{position:relative}
    .table-loading-overlay.show-loading{position:relative}
    .table-loading-overlay.show-loading::after{
        content:'';position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:50
    }
    .table-loading-inner{position:absolute;left:50%;top:40%;transform:translate(-50%,-50%);z-index:60}
</style>
