<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="{{ route('home') }}" class="waves-effect {{ Request::is('/') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span>
                    </a>
                </li>

                @if (Auth::user()->job_position == 'DIREKTUR')
                <li>
                    <a href="{{ route('employee.index') }}" class="waves-effect {{ Request::is('employee*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-account-multiple-outline"></i> <span> Karyawan</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ route('reimbursement.index') }}" class="waves-effect {{ Request::is('reimbursement*') ? 'mm-active' : '' }}">
                        <i class="fa-duotone fa-bars"></i> <span> Reimburstment</span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
</div>
<!-- Left Sidebar End -->
