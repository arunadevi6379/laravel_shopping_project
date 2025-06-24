<table id="expenseTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Retailer Name</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Expense Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->retailer_name }}</td>
                <td>{{ $expense->amount }}</td>
                <td>{{ $expense->payment_method }}</td>
                <td>{{ $expense->expense_date }}</td>
                <td>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
