<?php

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
		'Validé' => 'valide',
		'En cours' => 'en_cours',
		'En attente' => 'en_attente',
		'Terminé' => 'termine',
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
