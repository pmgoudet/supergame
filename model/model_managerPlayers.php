<?php

class ManagerPlayers extends ModelPlayer
{
  //METHOD

  public function addPlayer(): string
  {
    try {
      $req = $this->getBdd()->prepare("INSERT INTO players (pseudo, email, score, `password`) VALUES (?,?,?,?);");

      $pseudo = $this->getPseudo();
      $email = $this->getEmail();
      $score = $this->getScore();
      $password = $this->getPassword();

      $req->bindParam(1, $pseudo, PDO::PARAM_STR);
      $req->bindParam(2, $email, PDO::PARAM_STR);
      $req->bindParam(3, $score, PDO::PARAM_INT);
      $req->bindParam(4, $password, PDO::PARAM_STR);

      $req->execute();

      return "$pseudo a été enregistré en BDD.";
    } catch (EXCEPTION $error) {
      return $error->getMessage();
    }
  }

  public function getPlayers(): string | array
  {
    try {
      $req = $this->getBdd()->prepare('SELECT id, pseudo, email, score, `password` FROM players');
      $req->execute();
      $data = $req->fetchAll(PDO::FETCH_ASSOC);

      return $data;
    } catch (EXCEPTION $e) {
      return $e->getMessage();
    }
  }

  public function getPlayerByMail(): array | string
  {
    try {
      $req = $this->getBdd()->prepare("SELECT id, pseudo, email, score, `password` FROM players WHERE email = ? LIMIT 1");
      $email = $this->getEmail();
      $req->bindParam(1, $email, PDO::PARAM_STR);
      $req->execute();
      $data = $req->fetchAll(PDO::FETCH_ASSOC);

      return $data;
    } catch (EXCEPTION $e) {
      return $e->getMessage();
    }
  }
}

$manager = new ManagerPlayers;
