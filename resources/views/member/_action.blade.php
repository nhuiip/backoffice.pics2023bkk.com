<div class="btn-group">
    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
        aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
        @if ($payment_method != 1 && $payment_status != 2)
            <li>
                <a class="dropdown-item" href="javascript:;" data-text="Check Paid!"
                    data-url="{{ route('members.update', $id) }}" data-status="2" onclick="fncStatus(this)"><i
                        class="fa fa-check"></i>&nbsp; Check
                    Paid
                </a>
            </li>
        @endif
        @if ($payment_method != 1 && $payment_status != 1)
            <li><a class="dropdown-item" href="javascript:;" data-text="Check Paid!"
                    data-url="{{ route('members.update', $id) }}" data-status="1" onclick="fncStatus(this)"><i
                        class="fa fa-exclamation-circle"></i>&nbsp; Change to pending</a>
        @endif
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="javascript:;" data-text="Send Email!"
                data-url="{{ route('members.sendemail') }}" data-id="{{ $id }}" data-type="user"
                onclick="fncSendEmail(this)"><i class="fa fa-user"></i>&nbsp;
                Send Passward</a></li>
        <li><a class="dropdown-item" href="javascript:;" data-text="Send Email!"
                data-url="{{ route('members.sendemail') }}" data-id="{{ $id }}" data-type="remind"
                onclick="fncSendEmail(this)"><i class="fa fa-bell"></i>&nbsp;
                Send Reminder</a></li>
    </ul>
</div>
