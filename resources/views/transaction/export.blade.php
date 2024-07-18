<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export Excel</title>
</head>
<body>
    <table id="myTable">
        <thead>
            <tr>
                <th>MARCHAND</th>
                <th>PAYMENT MODE</th>
                <th>DATE</th>
                <th>AMOUNT</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ App\Models\Marchand::find($transaction->marchand_id)->nom ?? "" }}</td>
                <td>
                    @if ($transaction->modepaiement == "OM_CI")
                        Orange Money
                    @elseif ($transaction->modepaiement == "WAVE_CI")
                        Wave
                    @elseif ($transaction->modepaiement == "MTN_CI")
                        MTN Momo
                    @elseif ($transaction->modepaiement == "MOOV_CI")
                        Moov
                    @endif
                </td>
                <td>{{ date('d/m/Y H:i:s', strtotime($transaction->created_at)) }}</td>
                <td>{{ number_format($transaction->merchant_transaction_id, 0, ' ', ' ') }} xof</td>
                <td>
                    @if (in_array($transaction->statut, ['INITIATE', 'INITIATED', 'PENDING', 'processing']))
                        PENDING
                    @elseif (in_array($transaction->statut, ['SUCCEEDED', 'SUCCESS', 'SUCCES', 'VALIDED']))
                        SUCCESS
                    @elseif (in_array($transaction->statut, ['FAILED', 'EXPIRED', 'cancelled']))
                        FAILED
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
