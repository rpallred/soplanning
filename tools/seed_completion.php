<?php
/**
 * One-time seed for Feature 1 (completion tracking): creates the program's
 * cohorts and checklist items, and assigns existing trainees to their cohort.
 * Idempotent-ish: skips cohorts/requirements that already exist by label.
 * Run from the app root:  php tools/seed_completion.php
 */
chdir(__DIR__ . '//../www');
define('BASE', '.');
require '../config.inc';

function getOrCreateCohort($libelle, $annee, $population) {
    $existing = new GCollection('Cohort');
    $existing->db_load(array('libelle', '=', $libelle));
    if ($c = $existing->fetch()) {
        return $c->cohort_id;
    }
    $c = new Cohort();
    $c->libelle = $libelle;
    $c->annee = $annee;
    $c->population = $population;
    $c->db_save();
    $back = new GCollection('Cohort');
    $back->db_load(array('libelle', '=', $libelle));
    return $back->fetch()->cohort_id;
}

function addRequirements($cohortId, array $items) {
    $ordre = 1;
    foreach ($items as $libelle => $type) {
        $exists = new GCollection('Requirement');
        $exists->db_load(array('cohort_id', '=', $cohortId, 'libelle', '=', $libelle));
        if ($exists->fetch()) { $ordre++; continue; }
        $r = new Requirement();
        $r->cohort_id = $cohortId;
        $r->libelle = $libelle;
        $r->response_type = $type;
        $r->ordre = $ordre++;
        $r->actif = 'oui';
        $r->db_save();
    }
}

$year = '2026-2027';
$internCohort = getOrCreateCohort('Interns ' . $year, $year, 'trainee');
$fellowCohort = getOrCreateCohort('Fellows ' . $year, $year, 'trainee');
$supCohort    = getOrCreateCohort('Supervisors ' . $year, $year, 'supervisor');

$traineeItems = array(
    'Heart of HealthPoint'        => 'bool',
    'Cultural Immersion Activity' => 'bool',
    'Cultural Immersion Bingo'    => 'bool',
    'Cultural Immersion Elective 1' => 'bool',
    'Cultural Immersion Elective 2' => 'bool',
    'Critical Analysis'           => 'file',
    'Integrated Reports'          => 'date',
);
$supervisorItems = array(
    '2026-2027 Agreement Signed' => 'bool',
    'Added to NPTC'              => 'bool',
    'Fall 2026 Retreat RSVP'     => 'bool',
    'BHC III Eligibility Date'   => 'date',
    'Visit Shadowed'             => 'bool',
    'Mentor Assigned'            => 'bool',
);
addRequirements($internCohort, $traineeItems);
addRequirements($fellowCohort, $traineeItems);
addRequirements($supCohort, $supervisorItems);

// Assign trainees to cohorts by their existing team (1 = Interns, 2 = Fellows)
$users = new GCollection('User');
$users->db_load(array('user_groupe_id', '>', '0'));
$assigned = 0;
while ($u = $users->fetch()) {
    if ($u->user_id === 'ADM' || $u->user_id === 'publicspl') continue;
    $target = ($u->user_groupe_id == 2) ? $fellowCohort : $internCohort;
    if ($u->cohort_id != $target) {
        $u->cohort_id = $target;
        $u->db_save();
        $assigned++;
    }
}

echo "Cohorts: interns=$internCohort fellows=$fellowCohort supervisors=$supCohort\n";
echo "Trainees assigned to a cohort: $assigned\n";
$rc = db_query("SELECT cohort_id, COUNT(*) n FROM planning_requirement GROUP BY cohort_id");
while ($row = db_fetch_array($rc)) { echo "  cohort {$row['cohort_id']}: {$row['n']} requirements\n"; }
