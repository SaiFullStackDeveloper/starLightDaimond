<div class="dashboard_left" style="width: 24%;">
    
    <div class="das_left_inr">
    @if (Session::get('role') == 1 || Session::get('role') == 3)
    
    <div class="das_menu">
        <h4> Order Book</h4>
        <ul>
            <li class="{{ (request()->route()->named('order_form')) ? 'activ' : '' }}" ><a href="{{ route('order_form') }}">Order Form</a></li>
            <li class="{{ (request()->route()->named('order_history')) ? 'activ' : '' }}
                {{ (request()->route()->named('view_order_form')) ? 'activ' : '' }}">  <a href="{{ route('order_history') }} ">Order History</a></li>
            {{-- <li ><a href="#url">Order Status</a></li> --}}

        </ul>
    </div>
    <div class="das_menu">
        <h4> Manufacture</h4>
        <ul>
            <li class="{{ (request()->route()->named('filling_form')) ? 'activ' : '' }}"><a href="{{ route('filling_form') }}">Filing</a></li>
            <li class="{{ (request()->route()->named('mounting')) ? 'activ' : '' }}"><a href="{{ route('mounting') }}">Mounting</a></li>
            <li class="{{ (request()->route()->named('setting')) ? 'activ' : '' }}"><a href="{{ route('setting') }}">Setting</a></li>
            <li class="{{ (request()->route()->named('final_polish')) ? 'activ' : '' }}"><a href="{{ route('final_polish') }}">Final Polish</a></li>
        </ul>
    </div>

    @endif
        @if (Session::get('role') == 2 )
        <div class="das_menu">
            <h4> Manufacture</h4>
            <ul>
                <li class="{{ (request()->route()->named('filling_form')) ? 'activ' : '' }}"><a href="{{ route('filling_form') }}">Filing</a></li>
                <li class="{{ (request()->route()->named('mounting')) ? 'activ' : '' }}"><a href="{{ route('mounting') }}">Mounting</a></li>
                <li class="{{ (request()->route()->named('setting')) ? 'activ' : '' }}"><a href="{{ route('setting') }}">Setting</a></li>
                <li class="{{ (request()->route()->named('final_polish')) ? 'activ' : '' }}"><a href="{{ route('final_polish') }}">Final Polish</a></li>
            </ul>
        </div>
        <div class="das_menu">
            <h4> Repair</h4>
            <ul>
                <li class="{{ (request()->route()->named('repair_filling_form')) ? 'activ' : '' }}"><a href="{{ route('repair_filling_form') }}">Filing</a></li>
                <li class="{{ (request()->route()->named('repair_setting')) ? 'activ' : '' }}"><a href="{{ route('repair_setting') }}">Setting</a></li>
                <li class="{{ (request()->route()->named('repair_final_polish')) ? 'activ' : '' }}"><a href="{{ route('repair_final_polish') }}">Final Polish</a></li>
            </ul>
        </div>
        @endif

    </div>
</div>
