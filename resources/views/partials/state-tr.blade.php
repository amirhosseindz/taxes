<tr data-id="{{ $state->id }}">
    <td>{{ $state->name }}</td>
    <td>
        <button class="btn btn-primary btn-xs tooltips" title="Edit"
                data-edit-form="#editForm"
                data-edit-action="{{ route('states.edit', [$state->id], false) }}"><i
                    class="fa fa-fw fa-pencil"></i></button>
        <button class="btn btn-danger btn-xs tooltips" title="Delete"
                data-edit-form="#delForm" data-edit-id="{{ $state->id }}"><i
                    class="fa fa-fw fa-trash"></i></button>
    </td>
</tr>
