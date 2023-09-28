<?php

namespace App\Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Models\PlaysModel;
use App\Models\TeamsModel;
use App\Models\FaultsModel;
use App\Models\MatchsModel;
use App\Controllers\Controller;

class APIController extends Controller
{
    private function getMatchsStats($id)
    {
        $plays = new PlaysModel;
        $matches = $plays->request("SELECT COUNT(*) AS 'played' , SUM(plays.result = 'Win') AS wins,  SUM(plays.result = 'Draw')  AS draws,  SUM(plays.result = 'Lose')  AS loses FROM plays WHERE plays.teamId = ?", [$id])->fetch();

        $stats = [
            "Played" => $matches->played,
            "Wins" => $matches->wins,
            "Draws" => $matches->draws,
            "Loses" => $matches->loses,
        ];
        return $stats;
    }

    private function getWorstLose($id)
    {
        $loses = new PlaysModel;
        $loses = $loses->request("SELECT matchId from plays where teamId = ? and result = 'Lose'", [$id])->fetchAll();
        $worstLose = 0;
        $worstMatchId = 0;
        foreach ($loses as $lose) {
            $score = $this->getScore($lose->matchId);
            if ($score) {
                $diff = abs((int)$score[0]->goals - (int)$score[1]->goals);
                if ($diff > $worstLose) {
                    $worstLose = $diff;
                    $worstMatchId = $lose->matchId;
                }
            }
        }
        if ($worstMatchId != 0) {
            $match = new MatchsModel;
            $match->hydrate($match->findById($worstMatchId));
            $match->setOverview();
            $match->homeTeam = $match->homeTeam->toArray();
            $match->awayTeam = $match->awayTeam->toArray();
            $match->stadium = $match->stadium->toArray();
            return $match->toArray();
        } else {
            return [];
        }
    }

    private function getBestWin($id)
    {
        $wins = new PlaysModel;
        $wins = $wins->request("SELECT matchId from plays where teamId = ? and result = 'Win'", [$id])->fetchAll();
        $match = new MatchsModel;
        $bestWin = 0;
        $bestWinId = 0;
        foreach ($wins as $win) {
            $score = $this->getScore($win->matchId);
            if ($score) {
                $diff = abs((int)$score[0]->goals - (int)$score[1]->goals);
                if ($diff > $bestWin) {
                    $bestWin = $diff;
                    $bestWinId = $win->matchId;
                }
            }
        }
        if ($bestWinId != 0) {
            $match = new MatchsModel;
            $match->hydrate($match->findById($bestWinId));
            $match->setOverview();
            $match->homeTeam = $match->homeTeam->toArray();
            $match->awayTeam = $match->awayTeam->toArray();
            $match->stadium = $match->stadium->toArray();
            return $match->toArray();
        } else {
            return [];
        }
    }

    private function getScore($matchId)
    {
        $match = new MatchsModel;
        $score = $match->request("SELECT plays.teamId,  (select COUNT(goals.teamId) as goals
                                                             FROM `goals`
                                                             JOIN events on events.id = goals.eventId 
                                                             WHERE events.matchId = ? and goals.teamId = plays.teamId ) as goals
                                      FROM plays JOIN matchs on matchs.id = plays.matchId 
                                      WHERE matchs.id = ? 
                                      GROUP BY plays.teamId;", [$matchId, $matchId])->fetchAll();
        return $score;
    }

    private function getMatchDetail($matchId)
    {
        $match = new MatchsModel;
        $match->hydrate($match->findById($matchId));
        $match->setAllDetails();
        return (array)$match;
    }

    private function getBestScorer($id)
    {
        $teamsModell = new TeamsModel;
        $bestScorer = $teamsModell->request("SELECT players.name, players.surname, COUNT(*) as buts 
                                            FROM playerMatchInfos
                                            JOIN events on events.playerMatchInfoId = playerMatchInfos.id
                                            JOIN goals on goals.eventId = events.id 
                                            JOIN players on playerMatchInfos.playerId = players.id
                                            WHERE playerMatchInfos.teamId = ?
                                            GROUP BY playerMatchInfos.playerId 
                                            ORDER BY buts DESC LIMIT 5;", [$id])->fetchAll();

        return (array) $bestScorer;
    }

    private function getGoals($id)
    {
        $playsModel = new PlaysModel;
        $matches = $playsModel->request("SELECT matchId as id from plays where teamId = ?", [$id])->fetchAll();
        $goalsScored = 0;
        $goalsConceded = 0;
        foreach ($matches as $match) {
            $scores = $this->getScore($match->id);
            foreach ($scores as $score) {
                if ($score->teamId == $id) {
                    $goalsScored += $score->goals;
                } else {
                    $goalsConceded += $score->goals;
                }
            }
        }
        $goals = [
            "goalsScored" => $goalsScored,
            "goalsConceded" => $goalsConceded
        ];
        return $goals;
    }

    private function getCards($id)
    {
        $faultsModel = new FaultsModel;
        $cards = $faultsModel->request("SELECT SUM(faults.redCard) as redCard, SUM(faults.yellowCard) as yellowCard
                                        FROM `faults` 
                                        JOIN events on faults.eventId = events.id
                                        JOIN playerMatchInfos on events.playerMatchInfoId = playerMatchInfos.id
                                        WHERE playerMatchInfos.teamId = ?", [$id])->fetch();

        if (is_null($cards->redCard)) {
            $cards->redCard = 0;
        }
        if (is_null($cards->yellowCard)) {
            $cards->yellowCard = 0;
        }
        return (array)$cards;
    }


    public function lastMatches()
    {
        $matchsModel = new MatchsModel;
        $matchs = $matchsModel->getOverviews('lastMatchs');
        echo json_encode($matchs);
        exit();
    }

    public function matchDetail($id)
    {
        $match = new MatchsModel;
        $match->hydrate($match->findById($id));
        $match->setAllDetails();
        echo json_encode($match);
        exit();
    }

    public function teamStats($id)
    {
        $team = new TeamsModel;
        $team->hydrate($team->findById($id));
        $matchesStats = $this->getMatchsStats($id);
        $worstLose = $this->getWorstLose($id);
        $bestWin = $this->getBestWin($id);
        $bestScorer = $this->getBestScorer($id);
        $goals = $this->getGoals($id);
        $cards = $this->getCards($id);

        $stats = compact('team', 'matchesStats', 'worstLose', 'bestWin', 'bestScorer', 'goals', 'cards');
        echo (json_encode($stats));
    }

    public function teams()
    {
        $teamsModel = new TeamsModel;
        $teams = $teamsModel->findAll();
        echo (json_encode($teams));
    }
}