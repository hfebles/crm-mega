@foreach ($datas as $data)
    <tr>
        <td class="text-center">
            {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}</td>
        <td class="text-center">{{ $data->dni }}</td>

        <td>{{ $data->names }}</td>
        <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('transfers.new-transfer', $data->_id) }}" class="btn btn-info btn-sm text-white"
                    type="button">
                    <i class="fas fa-paper-plane"></i>
                </a>
                <button class="btn btn-warning btn-sm" type="button" onclick="" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExampleEdit" aria-controls="offcanvasExampleEdit">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </div>
        </td>
    </tr>
@endforeach
