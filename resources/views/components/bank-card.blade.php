<div class="card bg-gradient-primary">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <img src="{{ asset('storage/banks/'.$bank->icon) }}" alt="{{ $bank->name }}" class="img-fluid" style="height: 40px;" data-toggle="tooltip" data-original-title="{{ $bank->name }}" />
            </div>
            <div class="col-auto">
                <span class="badge badge-lg badge-success">Active</span>
            </div>
        </div>
        <div class="my-2">
            <span class="h6 surtitle text-light">Nomor Rekening</span>
            <div class="d-block h3 text-white">{{ $number }}</div>
            <span class="h6 surtitle text-light">Nama</span>
            <span class="d-block h4 text-white">{{ $name }}</span>
        </div>
    </div>
</div>
