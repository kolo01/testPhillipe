<table id="myTable">
    <thead>
        <tr>
            <th>MARCHAND</th>
            <th>TRANSACTION ID</th>
            <th>PAYMENT MODE</th>
            <th>DATE</th>
            <th>AMOUNT</th>
            <th>FEES</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
            @php
            $montant = $transaction->transacmontant;
            $fraistransaction = $transaction->fraistransaction;
            $frais = floatval($fraistransaction) * $montant * 1/100;
            $montant_paye = $montant - $frais;
            $montant_retrait = $montant + $frais;
            $montant = $transaction->type == 'retrait' ? $montant_retrait : $montant_paye;
            $id_transac = base64_encode($transaction->merchant_transaction_id);
            @endphp
        <tr>
            <td>{{ App\Models\Marchand::find($transaction->marchand_id)->nom ?? "" }}</td>
            <td>{{ $transaction->merchant_transaction_id }}</td>
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
            <td>{{$transaction->type == 'retrait' ? "-" : ""}}@if(isset($montant)){{$montant}} @else {{$montant ?? ""}} @endif</td>
            <td>{{$frais}}</td>
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
