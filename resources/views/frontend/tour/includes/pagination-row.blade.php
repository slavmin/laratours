<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-3">
            <div class="float-left text-white">
                Найдено: {!! $items->total() !!} 
                {{-- {{ trans_choice('labels.general.table.total', $items->total()) }} --}}
            </div>
        </div><!--col-->
        <div class="col-9">
            <div class="float-right">
                {!! $items->links() !!}
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!-- container -->