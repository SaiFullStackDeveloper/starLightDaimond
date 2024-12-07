<div class="dashboard_left">
    <div class="das_left_inr">
    @if (Session::get('role') == 1 )
    <div class="das_menu">
        <h4>Repair Order</h4>
        <ul>
            <li class="{{ (request()->route()->named('repair_index')) ? 'activ' : '' }}" ><a href="{{ route('repair_index') }}">Repair Form</a></li>
            <li class="{{ (request()->route()->named('repair_list')) ? 'activ' : '' }} ">  <a href="{{ route('repair_list') }} ">Repair History</a></li>
        </ul>
    </div>
    <div class="das_menu">
        <h4> Manufacture</h4>
        <ul>
            <li class="{{ (request()->route()->named('repair_filling_form')) ? 'activ' : '' }}"><a href="{{ route('repair_filling_form') }}">Filing</a></li>
            <li class="{{ (request()->route()->named('repair_setting')) ? 'activ' : '' }}"><a href="{{ route('repair_setting') }}">Setting</a></li>
            <li class="{{ (request()->route()->named('repair_final_polish')) ? 'activ' : '' }}"><a href="{{ route('repair_final_polish') }}">Final Polish</a></li>
        </ul>
    </div>

    @endif
        @if (Session::get('role') == 2 )
        <div class="das_menu">
            <h4> Manufacture</h4>
            <ul>
                <li class="{{ (request()->route()->named('repair_filling_form')) ? 'activ' : '' }}"><a href="{{ route('repair_filling_form') }}">Filing</a></li>
                <li class="{{ (request()->route()->named('repair_setting')) ? 'activ' : '' }}"><a href="{{ route('repair_setting') }}">Setting</a></li>
                <li class="{{ (request()->route()->named('repair_final_polish')) ? 'activ' : '' }}"><a href="{{ route('repair_final_polish') }}">Final Polish</a></li>
            </ul>
        </div>
        @endif

    </div>
</div>
