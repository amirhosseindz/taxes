<li {{ Request::is('states') ? 'class=active' : '' }}>
    <a href="{{ route('states.index') }}">
        <i class="fa fa-dropbox"></i>
        <span>States</span>
    </a>
</li>
