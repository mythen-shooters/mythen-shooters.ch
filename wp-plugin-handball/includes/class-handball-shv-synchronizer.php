<?php
require_once ('class-handball-model.php');
require_once ('class-handball-repository.php');

class HandballShvSynchronizer
{

    private $apiUrl;

    private $apiUsername;

    private $apiPassword;

    private $clubId;

    private $teamRepo;

    private $matchRepo;

    private $groupRepo;

    public function __construct($apiUrl, $apiUsername, $apiPassword, $clubId)
    {
        $this->apiUrl = $apiUrl;
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;
        $this->clubId = $clubId;
        $this->teamRepo = new HandballTeamRepository();
        $this->matchRepo = new HandballMatchRepository();
        $this->groupRepo = new HandballGroupRepository();
    }

    public function start()
    {
        if (! $this->validConfig()) {
            return;
        }

        $teamIds = $this->updateTeams($this->clubId);

        foreach ($teamIds as $teamId) {
            $this->updateMatches($teamId);
            $this->updateGroup($teamId);
        }
    }

    private function validConfig()
    {
        if (empty($this->apiUrl)) {
            return false;
        }
        if (empty($this->apiUsername)) {
            return false;
        }
        if (empty($this->apiPassword)) {
            return false;
        }
        if (empty($this->clubId)) {
            return false;
        }
        return true;
    }

    private function updateTeams($clubId)
    {
        $responseTeams = $this->fetchBody($this->apiUrl . '/clubs/' . $clubId . '/teams');

        $teamIds= [];
        foreach ($responseTeams as $responseTeam) {
            $team = $this->teamRepo->findById($responseTeam->teamId);
            if ($team == null) {
                $team = new Team($responseTeam->teamId, $responseTeam->teamName, Saison::getCurrentSaisonBasedOnTime()->getValue());
            }
            $team->setTeamName($responseTeam->teamName);

            $responseDetailTeam = $this->fetchBody($this->apiUrl . '/teams/' . $team->getTeamId());
            $team->setLeagueLong($responseDetailTeam->leagueLong);
            $team->setLeagueShort($responseDetailTeam->leagueShort);

            $this->teamRepo->saveTeam($team);

            if (!isset($teamIds[$responseTeam->teamId])) {
                $teamIds[] = $responseTeam->teamId;
            }
        }

        return $teamIds;
    }

    private function updateMatches($teamId)
    {
        // Hack, because API limits always to 30
        $responseMatchesPlanned = $this->fetchBody($this->apiUrl . '/teams/' . $teamId . '/games?status=planned');
        $responseMatchesPlayed = $this->fetchBody($this->apiUrl . '/teams/' . $teamId . '/games?status=played');

        $responseMatches = [];
        foreach ($responseMatchesPlanned as $match) {
            $responseMatches[] = $match;
        }
        foreach ($responseMatchesPlayed as $match) {
            $responseMatches[] = $match;
        }

        foreach ($responseMatches as $responseMatch) {
            if (empty($responseMatch->gameId)) {
                continue;   
            }
            
            $match = $this->matchRepo->findById($responseMatch->gameId);
            if ($match == null) {
                $match = new Game($responseMatch->gameId, $responseMatch->gameNr, $teamId);
            }
            $match->setGameNr($responseMatch->gameNr);
            $match->setTeamAName($responseMatch->teamAName);
            $match->setTeamBName($responseMatch->teamBName);
            $match->setTeamAId($responseMatch->teamAId);
            $match->setTeamBId($responseMatch->teamBId);
            $match->setTeamAClubId($responseMatch->clubTeamAId);
            $match->setTeamBClubId($responseMatch->clubTeamBId);
            $match->setGameDateTime($responseMatch->gameDateTime);
            $match->setGameTypeLong($responseMatch->gameTypeLong);
            $match->setGameTypeShort($responseMatch->gameTypeShort);
            $match->setLeagueLong($responseMatch->leagueLong);
            $match->setLeagueShort($responseMatch->leagueShort);
            $match->setGameStatus($responseMatch->gameStatus);
            $match->setRound($responseMatch->round ?? null);
            $match->setRoundNr($responseMatch->roundNr);
            $match->setSpectators($responseMatch->spectators);
            $match->setTeamAScoreFT($responseMatch->teamAScoreFT);
            $match->setTeamAScoreHT($responseMatch->teamAScoreHT);
            $match->setTeamBScoreFT($responseMatch->teamBScoreFT);
            $match->setTeamBScoreHT($responseMatch->teamBScoreHT);
            $match->setVenue($responseMatch->venue);
            $match->setVenueAddress($responseMatch->venueAddress);
            $match->setVenueCity($responseMatch->venueCity);
            $match->setVenueZip($responseMatch->venueZip);

            $this->matchRepo->saveMatch($match);
        }
    }

    private function updateGroup($teamId)
    {
        $responseGroup = $this->fetchBody($this->apiUrl . '/teams/' . $teamId . '/group?status=planned');

        // Handball API Bug
        if ($responseGroup->groupId == 0) {
            return;
        }

        $group = $this->groupRepo->findById($responseGroup->groupId, $teamId);
        if ($group == null) {
            $group = new Group($responseGroup->groupId, $teamId);
        }
        $group->setGroupText($responseGroup->groupText);
        $group->setLeagueId($responseGroup->leagueId);
        $group->setLeagueShort($responseGroup->leagueShort);
        $group->setLeagueLong($responseGroup->leagueLong);
        $group->setRanking(json_encode($responseGroup->ranking));
        $this->groupRepo->saveGroup($group);
    }

    private function fetchBody($url)
    {
        $response = wp_remote_get($url, $this->createRequestArguments());
        $body = wp_remote_retrieve_body($response);
        return json_decode($body);
    }

    private function createRequestArguments()
    {
        return [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->apiUsername . ':' . $this->apiPassword)
            ]
        ];
    }

}
