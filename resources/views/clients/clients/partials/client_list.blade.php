@foreach ($datas as $data)
    <tr>
        <td class="text-center">
            {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}</td>
        <td class="text-center">{{ $data->dni }}</td>

        <td>{{ $data->names }}</td>
        <td class="text-center">{{ $data->phone }}</td>

        <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('transfers.new-transfer', $data->_id) }}" class="btn btn-info btn-sm text-white"
                    type="button">
                    <i class="fas fa-paper-plane"></i>
                </a>
                <a class="btn btn-primary btn-sm text-white" href="{{ route('clients.show', $data->_id) }}">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </a>
                <a href="{{ route('clients.delete', $data->_id) }}" type="button" class="btn btn-danger btn-sm"><i
                        class="fas fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach
