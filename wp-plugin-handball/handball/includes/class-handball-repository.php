<?php
require_once ('class-handball-model.php');

abstract class Repository
{
    protected $wpdb;
    
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    
    protected function mapObjects($rows)
    {
        return array_map([$this, 'mapObject'], $rows);
    }
    
    protected function findOne($query)
    {
        $row = $this->wpdb->get_row($query);
        return $row ? $this->mapObject($row) : null;
    }
    
    protected function findMultiple($query)
    {
        $results = $this->wpdb->get_results($query);
        return $this->mapObjects($results);
    }
}

class HandballTeamRepository extends Repository
{
    public function saveTeam(Team $team)
    {
        $data = [
            'team_id' => $team->getTeamId(),
            'team_name' => $team->getTeamName(),
            'saison' => $team->getSaison()->getValue(),
            'league_short' => $team->getLeagueShort(),
            'league_long' => $team->getLeagueLong()
        ];
        $format = [
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d'
        ];
        if ($this->existsTeam($team->getTeamId())) {
            $this->wpdb->update('handball_team', $data, ['team_id' => $team->getTeamId()], $format, ['%d']);
        } else {
            $this->wpdb->insert('handball_team', $data, $format);
        }
    }
    
    private function existsTeam($teamId)
    {
        return $this->findById($teamId) != null;
    }
    
    public function findAll(): array
    {
        $query = 'SELECT * FROM handball_team ORDER BY saison DESC';
        return $this->findMultiple($query);
    }
    
    public function findAllBySaisonWithPost(?Saison $saison): array {
        $teams = $this->findAllBySaison($saison);
        $t = [];
        foreach ($teams as $team) {
            if ($team->findPost() != null) {
                $t[] = $team;
            }
        }
        return $t;
    }
    
    public function findAllBySaison(?Saison $saison): array
    {
        if ($saison == null) {
            return [];
        }
        $query = $this->wpdb->prepare('SELECT * FROM handball_team WHERE saison = %s ORDER BY saison DESC', $saison->getValue());
        $teams = $this->findMultiple($query);
        return $teams;
    }
    
    public function findById($id): ?Team
    {
        $query = $this->wpdb->prepare('SELECT * FROM handball_team WHERE team_id = %d', $id);
        return $this->findOne($query);
    }
    
    protected function mapObject($row): Team
    {
        $team = new Team($row->team_id, $row->team_name, $row->saison);
        $team->setLeagueLong($row->league_long);
        $team->setLeagueShort($row->league_short);
        return $team;
    }
}

class HandballSaisonRepository extends Repository
{
    public function findAll()
    {
        $saisons = $this->wpdb->get_results('SELECT DISTINCT saison FROM handball_team ORDER BY saison ASC');
        $map = array_map(function ($saison) { return new Saison($saison->saison); }, $saisons);
        return $map;
    }
}

class HandballEventRepository
{
    
    public function findUpComingEvents()
    {
        $events = $this->loadPostsOfTypeEvent(function ($event) {
            return $event->isUpComing();
        });
        
        usort($events, function (Event $a, Event $b) {
          return $a->getStartTimestamp() <=> $b->getStartTimestamp();
        });

        return $events;
    }
    
    public function findNextEvent(): ?Event
    {
        $events = $this->findUpComingEvents();
        if (isset($events[0])) {
            return $events[0];
        }
        return null;
    }
    
    public function findPastEvents()
    {
        $events = $this->loadPostsOfTypeEvent(function ($event) {
            return ! $event->isUpComing();
        });
        usort($events, function (Event $a, Event $b) {
          return $b->getStartTimestamp() <=> $a->getStartTimestamp();
        });
        return $events;
    }
    
    private function loadPostsOfTypeEvent($filterCallable) {
        $postQuery = new WP_Query([
            'post_type' => 'handball_event',
            'post_status' => 'publish',
            'posts_per_page' => 1000
        ]);
        $events = [];
        while ($postQuery->have_posts()) {
            $postQuery->the_post();
            $event = new Event($postQuery->post);
            if ($filterCallable($event)) {
                $events[] = $event;
            }
        }
        return $events;
    }
}

class HandballGalleryRepository
{
    public function findNewest(): ?Gallery
    {
        $postQuery = new WP_Query([
            'post_type' => 'handball_gallery',
            'post_status' => 'publish',
            'orderby' => 'publish_date',
            'order' => 'DESC',
        ]);
        
        while ($postQuery->have_posts()) {
            $postQuery->the_post();
            return new Gallery($postQuery->post);
        }
        return null;
    }
    
    public function findAll()
    {
        $galleries = $this->loadPostsOfTypeGallery();
        usort($galleries, function (Gallery $a, Gallery $b) {
            return $b->getDateTimestamp() <=> $a->getDateTimestamp();
        });
        return $galleries;
    }
    
    private function loadPostsOfTypeGallery()
    {
        $postQuery = new WP_Query([
            'post_type' => 'handball_gallery',
            'post_status' => 'publish',
            'posts_per_page' => 1000
        ]);
        $galleries= [];
        while ($postQuery->have_posts()) {
            $postQuery->the_post();
            $galleries[] = new Gallery($postQuery->post);
        }
        return $galleries;
    }
}

class HandballGroupRepository extends Repository
{
    public function saveGroup(Group $group) {
        $data = [
            'group_id' => $group->getGroupId(),
            'group_text' => $group->getGroupText(),
            'league_id' => $group->getLeagueId(),
            'league_short' => $group->getLeagueShort(),
            'league_long' => $group->getLeagueLong(),
            'ranking' => $group->getRanking(),
            'fk_team_id' => $group->getTeamId()
        ];
        $format = [
            '%d',
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%d'
        ];
        if ($this->existsGroup($group->getGroupId(), $group->getTeamId())) {
            $this->wpdb->update('handball_group', $data, ['group_id' => $group->getGroupId(), 'fk_team_id' => $group->getTeamId()], $format, ['%d']);
        } else {
            $this->wpdb->insert('handball_group', $data, $format);
        }
    }
    
    public function findGroupsByTeamId($teamId): array
    {
        $query = $this->wpdb->prepare('SELECT * FROM handball_group WHERE fk_team_id = %d', $teamId);
        return $this->findMultiple($query);
    }
    
    public function findById($groupId, $teamId): ?Group
    {
        $query = $this->wpdb->prepare('SELECT * FROM handball_group WHERE group_id = %d AND fk_team_id = %d', $groupId, $teamId);
        return $this->findOne($query);
    }
    
    protected function mapObject($row): Group
    {
        $group = new Group($row->group_id, $row->fk_team_id);
        $group->setGroupText($row->group_text);
        $group->setLeagueId($row->league_id);
        $group->setLeagueLong($row->league_long);
        $group->setLeagueShort($row->league_short);
        $group->setRanking($row->ranking);
        return $group;
    }
    
    private function existsGroup($groupId, $teamId)
    {
        return $this->findById($groupId, $teamId) != null;
    }
}

class HandballMatchRepository extends Repository
{
    public function saveMatch($match)
    {
        $data = [
            'game_id' => $match->getGameId(),
            'game_nr' => $match->getGameNr(),
            'fk_team_id' => $match->getTeamId(),
            'game_datetime' => $match->getGameDateTime(),
            'team_a_name' => $match->getTeamAName(),
            'team_b_name' => $match->getTeamBName(),
            'game_type_long' => $match->getGameTypeLong(),
            'game_type_short' => $match->getGameTypeShort(),
            'venue' => $match->getVenue(),
            'venue_address' => $match->getVenueAddress(),
            'venue_city' => $match->getVenueCity(),
            'venue_zip' => $match->getVenueZip(),
            'league_long' => $match->getLeagueLong(),
            'league_short' => $match->getLeagueShort(),
            'game_status' => $match->getGameStatus(),
            'team_a_score_ht' => $match->getTeamAScoreHT(),
            'team_a_score_ft' => $match->getTeamAScoreFT(),
            'team_b_score_ht' => $match->getTeamBScoreHT(),
            'team_b_score_ft' => $match->getTeamBScoreFT(),
            'spectators' => $match->getSpectators(),
            'round_nr' => $match->getRoundNr(),
            'team_a_id' => $match->getTeamAId(),
            'team_b_id' => $match->getTeamBId(),
            'team_a_club_id' => $match->getTeamAClubId(),
            'team_b_club_id' => $match->getTeamBClubId(),
        ];
        $format = [
            '%d',
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
        ];
        
        $existingMatch = $this->findById($match->getGameId());
        if ($existingMatch == null) {
            $this->wpdb->insert('handball_match', $data, $format);
        } else {
            $this->wpdb->update('handball_match', $data, ['game_id' => $match->getGameId()], $format, ['%d']);
        }
    }
    
    public function findAll(): array
    {
        return $this->findMultiple('SELECT * FROM handball_match ORDER BY game_datetime');
    }
    
    public function findMatchesForTeam($teamId): array
    {
        $query = $this->wpdb->prepare('SELECT * FROM handball_match WHERE fk_team_id = %d ORDER BY game_datetime', $teamId);
        return $this->findMultiple($query);
    }
    
    public function findMatchesNextWeek(): array {
        $query = 'SELECT * FROM handball_match
            WHERE game_datetime < (DATE_ADD(NOW(), INTERVAL 3 WEEK)) AND game_datetime > (NOW())
            ORDER BY game_datetime ASC';
        return $this->findMultiple($query);
    }
    
    public function findMatchesLastWeek(): array {
        $query = 'SELECT * FROM handball_match
            WHERE game_datetime > (DATE_SUB(NOW(), INTERVAL 3 WEEK)) AND game_datetime < (NOW())
            ORDER BY game_datetime ASC';
        return $this->findMultiple($query);
    }

    public function findNextMatch(int $teamId): ?Game {
        $query = $this->wpdb->prepare('SELECT * FROM handball_match WHERE game_datetime > (NOW()) AND fk_team_id = %d ORDER BY game_datetime ASC', $teamId);
        $games = $this->findMultiple($query);
        if (empty($games)) {
            return null;
        }
        return $games[0];
    }

    public function findLastMatch(int $teamId): ?Game {
        $query = $this->wpdb->prepare('SELECT * FROM handball_match WHERE game_datetime < (NOW()) AND fk_team_id = %d ORDER BY game_datetime DESC', $teamId);
        $games = $this->findMultiple($query);
        if (empty($games)) {
            return null;
        }
        return $games[0];
    }
    
    public function findById($id): ?Game
    {
        $query = $this->wpdb->prepare('SELECT * FROM handball_match WHERE game_id = %d', $id);
        return $this->findOne($query);
    }
    
    public function delete($gameId)
    {
        $this->wpdb->delete('handball_match', ['game_id' => $gameId]);
    }
    
    protected function mapObject($row)
    {
        $match= new Game($row->game_id, $row->game_nr, $row->fk_team_id);
        $match->setTeamAName($row->team_a_name);
        $match->setTeamBName($row->team_b_name);
        $match->setTeamAId($row->team_a_id);
        $match->setTeamBId($row->team_b_id);
        $match->setTeamAClubId($row->team_a_club_id);
        $match->setTeamBClubId($row->team_b_club_id);

        $match->setGameDateTime($row->game_datetime);
        $match->setLeagueShort($row->league_short);
        $match->setLeagueLong($row->league_long);
        $match->setTeamAScoreFT($row->team_a_score_ft);
        $match->setTeamBScoreFT($row->team_b_score_ft);
        $match->setTeamAScoreHT($row->team_a_score_ht);
        $match->setTeamBScoreHT($row->team_b_score_ht);
        $match->setSpectators($row->spectators);
        $match->setRoundNr($row->round_nr);
        $match->setGameTypeShort($row->game_type_short);
        $match->setGameTypeLong($row->game_type_short);
        $match->setGameStatus($row->game_status);
        $match->setVenue($row->venue);
        $match->setVenueCity($row->venue_city);
        $match->setVenueZip($row->venue_zip);
        $match->setVenueAddress($row->venue_address);
        return $match;
    }
}