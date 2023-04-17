<div>
    {{-- Stop trying to control. --}}
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Work Order</th>
                    <th>Desc</th>
                    <th>Group</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($tablepmnotcomply as $item)
                    <tr>
                        <td>{{ ($tablepmnotcomply->currentPage() - 1) * $tablepmnotcomply->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $item->plan_fin_date }}</td>
                        <td>{{ $item->work_order }}</td>
                        <td>{{ $item->wo_task_desc }}</td>
                        <td>{{ $item->work_group }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col mt-3 px-3">
            {{ $tablepmnotcomply->links() }}
        </div>
    </div>
</div>
