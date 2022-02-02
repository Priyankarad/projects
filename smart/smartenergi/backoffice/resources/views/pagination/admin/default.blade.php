<div class="dataTables_paginate paging_bootstrap pagination" style="margin:0 auto 20px auto; float:none; text-align:center">

@if(!$link_limit)
    @if ($paginator->lastPage() > 1)
    <ul>
        <li class="{{ $paginator->currentPage() == 1 ? 'prev disabled' : '' }}">
            
			@if($paginator->currentPage() == 1)
				<a aria-label="Previous" href="javascript:void(0);">← Previous</a>
			@else
				<a aria-label="Previous" href="{{ $paginator->url($paginator->currentPage()-1) }}">← Previous</a>
			@endif
			
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'next disabled' : '' }}">
            
			@if($paginator->currentPage() == $paginator->lastPage())
			<a aria-label="Next" href="javascript:void(0);">Next → </a>
			@else
			<a aria-label="Next" href="{{ $paginator->url($paginator->currentPage()+1) }}">Next → </a>
			@endif
			
        </li>
    </ul>
    @endif
@else
    @if ($paginator->lastPage() > 1)
        <ul>
            <li class="{{ $paginator->currentPage() == 1 ? 'prev disabled' : '' }}">
                @if($paginator->currentPage() == 1)
					<a aria-label="Previous" href="javascript:void(0);">← Previous</a>
				@else
					<a aria-label="Previous" href="{{ $paginator->url($paginator->currentPage()-1) }}">← Previous</a>
				@endif				
             </li>
             <?php
                $half_total_links = floor($link_limit / 2);
                $from = ($paginator->currentPage() - $half_total_links) < 1 ? 1 : $paginator->currentPage() - $half_total_links;
                $to = ($paginator->currentPage() + $half_total_links) > $paginator->lastPage() ? $paginator->lastPage() : ($paginator->currentPage() + $half_total_links);
                if ($from > $paginator->lastPage() - $link_limit) {
                   $from = ($paginator->lastPage() - $link_limit) + 1;
                   $to = $paginator->lastPage();
                }
                if ($to <= $link_limit) {
                    $from = 1;
                    $to = $link_limit < $paginator->lastPage() ? $link_limit : $paginator->lastPage();
                }
            ?>
            @for ($i = $from; $i <= $to; $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
            @endfor
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'next disabled' : '' }}">
            
				@if($paginator->currentPage() == $paginator->lastPage())
                <a aria-label="Next" href="javascript:void(0);">Next → </a>
                @else
                <a aria-label="Next" href="{{ $paginator->url($paginator->currentPage()+1) }}">Next → </a>
                @endif
				
			</li>
        </ul>
    @endif
@endif

</div>