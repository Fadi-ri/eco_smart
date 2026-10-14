<?php


#securite  this converts special HTML characters (<, >, &, ", ') to HTML entities to prevent Cross-Site Scripting (XSS) attacks.
function e($value): string
{
	return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function set_flash(string $type, string $message): void
{
	$_SESSION['flash'] = [
		'type' => $type,
		'message' => $message,
	];
}

function display_flash(): string
{
	$flash = $_SESSION['flash'] ?? null;
	unset($_SESSION['flash']);

	if (!is_array($flash) || !isset($flash['message'])) {
		return '';
	}

	$allowedTypes = ['success', 'danger', 'warning', 'info'];
	$type = in_array($flash['type'] ?? '', $allowedTypes, true) ? $flash['type'] : 'info';

	return '<div class="alert alert-' . e($type) . ' alert-dismissible fade show" role="alert">'
		. e($flash['message'])
		. '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>'
		. '</div>';
}

function get_status_badge(string $statut): string
{
	$styles = [
		'Valide'     => 'bg-success-subtle text-success',
		'En cours'   => 'bg-primary-subtle text-primary',
		'En attente' => 'bg-warning-subtle text-warning',
		'Termine'    => 'bg-secondary-subtle text-secondary',
		'Rejete'     => 'bg-danger-subtle text-danger',
	];
	$class = $styles[$statut] ?? 'bg-secondary-subtle text-secondary';

	return '<span class="badge ' . $class . ' small fw-semibold">' . e($statut) . '</span>';
}

function format_currency(float $amount): string
{
	return number_format($amount, 0, ',', ' ') . ' €';
}

function format_date(string $date): string
{
	$timestamp = strtotime($date);
	return $timestamp ? date('d/m/Y', $timestamp) : e($date);
}

function generate_csrf_token(): string
{
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
	return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}

function get_project_stats(PDO $pdo): array
{
	$stats = [
		'total' => 0,
		'valide' => 0,
		'en_cours' => 0,
		'en_attente' => 0,
		'termine' => 0,
		'budget_total' => 0.0,
	];

	$projects = $pdo->query('SELECT statut, budget_estime FROM projets_inscriptions')->fetchAll();
	$statusKeys = [
		'Valide' => 'valide',
		'En cours' => 'en_cours',
		'En attente' => 'en_attente',
		'Termine' => 'termine',
	];

	foreach ($projects as $project) {
		$stats['total']++;
		$stats['budget_total'] += (float) ($project['budget_estime'] ?? 0);

		$key = $statusKeys[$project['statut'] ?? ''] ?? null;
		if ($key !== null) {
			$stats[$key]++;
		}
	}

	return $stats;
}
