<?php
include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

date_default_timezone_set('UTC');

function date2word($dif, $short = true)
{
	$dif *= 60;

	if($dif) {
		$s = '';
		$years = intval($dif / (60 * 60 * 24 * 365));
		$dif = $dif - ($years * (60 * 60 * 24 * 365));

		if($years) {
			$s .= "{$years} років ";
		}
		if($years && $short) {
			return $s;
		}

		$months = intval($dif / (60 * 60 * 24 * 30));
		$dif = $dif - ($months * (60 * 60 * 24 * 30));
		if($months) {
			$s .= "{$months} міс. ";
		}
		if($months && $short) {
			return $s;
		}

		$weeks = intval($dif / (60 * 60 * 24 * 7));
		$dif = $dif - ($weeks * (60 * 60 * 24 * 7));

		if($weeks) {
			$s .= "{$weeks} тиж. ";
		}

		if($weeks && $short) {
			return $s;
		}

		$days = intval($dif / (60 * 60 * 24));
		$dif = $dif - ($days * (60 * 60 * 24));
		if($days) {
			$s .= "{$days} дн. ";
		}
		if($days && $short) {
			return $s;
		}

		$hours = intval($dif / (60 * 60));
		$dif = $dif - ($hours * (60 * 60));
		if($hours) {
			$s .= "{$hours} год. ";
		}
		if($hours && $short) {
			return $s;
		}

		$minutes = intval($dif / 60);
		$seconds = $dif - ($minutes * 60);
		if($minutes) {
			$s .= "{$minutes} хв.";
		}
		if($minutes && $short) {
			return $s;
		}

		if($short) {
			return "{$seconds} сек.";
		}

		return $s;
	} else {
		return;
	}
}



try {
	$pdo = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=' . DBCHARSET, DBUSER, DBPASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$now = time();
	$counts = (int)$pdo->query('SELECT COUNT(*) FROM amx_bans')->fetch(PDO::FETCH_COLUMN);
	$page = isset($_GET['p']) ? (int)$_GET['p'] - 1 : 0;

	$bans = $pdo->query('SELECT ab.id, ab.player_authid, ab.player_ip, ab.player_nick, ab.reason, UNIX_TIMESTAMP(ab.created) created, ab.length, ab.expired, IFNULL(aa.nickname, aas.hostname) admin_nick, aas.hostname
	FROM amx_bans ab
	LEFT JOIN amx_admins aa ON aa.id = ab.admin_id
	LEFT JOIN amx_servers aas ON ab.server_id = aas.id
	ORDER BY ab.created DESC
	LIMIT ' . COUNT_PER_PAGE . ' OFFSET ' . ($page * COUNT_PER_PAGE))->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die('Сторінка наразі недоступна');
}
?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Headshots Party ^-^ (UA)</title>
	<link rel="stylesheet" href="bootstrap.min.css">
	<link rel="icon" type="image/png" href="icon001.png" />
	<style type="text/css">
		/*body {
			background-image: url("background001.png");
			background-repeat: repeat;
			color: #ffffff;
		}

		.table-striped > tbody > tr:nth-of-type(2n+1) {
			background-color: #010101;
		}*/
	</style>
</head>
<body>
<div class="container">
	<img src="logo001.png" class="center-block" alt="Headshots Party ^-^ (UA)">
	<br>
	<?php if (count($bans)): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Гравець</th>
				<th>STEAMID</th>
				<th>Адмін</th>
				<?php if (SHOW_SERVER): ?>
				<th>Сервер</th>
				<?php endif; ?>
				<th>Причина</th>
				<th>Час бану</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($bans as $ban): ?>
			<?php $expired = $ban['created'] + $ban['length']; ?>
			<tr>
				<td><?php echo date('d.m.Y H:i:s', $ban['created']); ?></td>
				<td><?php echo $ban['player_nick']; ?></td>
				<td><?php echo $ban['player_authid']; ?></td>
				<td><?php echo $ban['admin_nick']; ?></td>
				<?php if (SHOW_SERVER): ?>
				<td><?php echo $ban['hostname']; ?></td>
				<?php endif; ?>
				<td><?php echo !empty($ban['reason']) ? $ban['reason'] : 'Без бричини'; ?></td>
				<td>
					<?php if($ban['length'] == 0): ?>
						<?php echo $ban['expired'] == '1' ? '<span class="text-danger">Назавжди</span>(<span class="text-primary">Розбанений</span>)' : '<span class="text-danger">Назавжди</span>'; ?>
					<?php else: ?>
						<?php echo ($ban['expired'] == '1' || $expired < $now) ?  '<span class="text-muted">' . date2word($ban['length'], true) . '</span>(<span class="text-primary">Минув</span>)' : '<span class="text-warning">' . date2word($expired - $now, false) . '</span>'; ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php else: ?>
		<p>Немає даних для відображення</p>
	<?php endif; ?>
	<?php if ($counts > COUNT_PER_PAGE): ?>
		<?php
		$pagesCount = ceil($counts / COUNT_PER_PAGE);
		$startPage = $page - 5;
		$endPage = $page + 5;
		if ($startPage < 0) $startPage = 0;
		if ($endPage > $pagesCount) $endPage = $pagesCount;
		?>
		<nav>
			<ul class="pagination">
				<?php if ($page > 5): ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo FILE_URL . '?p=' . $page; ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					</a>
				</li>
				<li class="page-item"><a class="page-link" href="<?php echo FILE_URL . '?p=1'; ?>">&nbsp;1&nbsp;</a></li>
				<?php endif; ?>
				<?php for($i = $startPage; $i < $endPage; $i++): ?>
					<?php if ($i == $page): ?>
						<li class="page-item active"><a class="page-link" href="<?php echo FILE_URL . '?p=' . ($i + 1); ?>"><?php echo ($i + 1); ?> <span class="sr-only">(current)</span></a></li>
					<?php else: ?>
						<li class="page-item"><a class="page-link" href="<?php echo FILE_URL . '?p=' . ($i + 1); ?>"><?php echo ($i + 1); ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>
				<?php if ($page < $pagesCount - 5): ?>
				<li class="page-item"><a class="page-link" href="<?php echo FILE_URL . '?p=' . $pagesCount; ?>">&nbsp;<?php echo $pagesCount; ?>&nbsp;</a></li>
				<li class="page-item">
					<a class="page-link" href="<?php echo FILE_URL . '?p=' . ($page + 2); ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
	<?php endif; ?>
</div>
</body>
</html>