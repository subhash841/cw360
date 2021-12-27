<div class="col-md-12" style=";position: relative;margin-top: 20px;margin-bottom: 200px"> 
	<center>
		<?php if (!empty($transaction_details)): ?>
			<h2 style="margin-top: 50px;margin-bottom: 40px"><?=$transaction_details['payment_status']; ?></h2>
			<?php if ($transaction_details['response_code']=='E000'):?>
				<p><strong>Transacton ID:</strong> <?=$transaction_details['transaction_id']?></p>
				<p><strong>Coins purchased:</strong> <?=round($transaction_details['coins'])?></p>
				<p><strong>Transaction amount:</strong> <?=$transaction_details['transaction_amount']?></p>
			<?php elseif ($transaction_details['response_code']!='E000' && $transaction_details['response_code']!=501):?>
				<p><strong>Transacton ID:</strong> <?=$transaction_details['transaction_id']?></p>
				<p><strong>Payment failure reason:</strong> <?=$transaction_details['trans_response']?></p>
				<p><strong>Coins to be purchased:</strong> <?=round($transaction_details['coins'])?></p>
				<p><strong>Transaction amount:</strong> <?=$transaction_details['transaction_amount']?></p>
			<?php endif; ?>
		<?php else: ?>
			<h2 style="margin-top: 50px;margin-bottom: 40px">Something went wrong. Try again later.</h2>
		<?php endif; ?>
	</center>	
</div>