@if(auth()->user()->isAdmin())
    <div class="item-asoc">
        <div>
            <span
                class="item-asoc-a {{$item->asoc == 'a' ?: 'item-asoc-a-disabled'}}">A</span>
        </div>
        <div>
            <span
                class="item-asoc-b {{$item->asoc == 'b' ?: 'item-asoc-b-disabled'}}">B</span>
        </div>
        <div>
            <span
                class="item-asoc-c {{$item->asoc == 'c' ?: 'item-asoc-c-disabled'}}">C</span>
        </div>
    </div>

    <hr/>

    <section class="item-priority">
        {!!ProgressBar::normal($item->priority)->value('Prioridad de ')!!}
    </section>
@endif
