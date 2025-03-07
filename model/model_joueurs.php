<?php

class ModelPlayer
{

  private ?int $id;
  private ?string $pseudo;
  private ?string $email;
  private ?int $score;
  private ?string $password;
  private ?PDO $bdd;

  public function __construct()
  {
    $this->bdd = connect();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): self
  {
    $this->id = $id;
    return $this;
  }

  public function getPseudo(): ?string
  {
    return $this->pseudo;
  }

  public function setPseudo(?string $pseudo): self
  {
    $this->pseudo = $pseudo;
    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(?string $email): self
  {
    $this->email = $email;
    return $this;
  }

  public function getScore(): ?int
  {
    return $this->score;
  }

  public function setScore(?int $score): self
  {
    $this->score = $score;
    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(?string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function getBdd(): ?PDO
  {
    return $this->bdd;
  }

  public function setBdd(?PDO $bdd): self
  {
    $this->bdd = $bdd;
    return $this;
  }

  //METHOD
  public function addPlayer(): string
  {
    try {
      $req = $this->getBdd()->prepare("INSERT INTO players (pseudo, email, score, `psswrd`) VALUES (?,?,?,?);");

      $pseudo = $this->getPseudo();
      $email = $this->getEmail();
      $score = $this->getScore();
      $password = $this->getPassword();

      $req->bindParam(1, $pseudo, PDO::PARAM_STR);
      $req->bindParam(2, $email, PDO::PARAM_STR);
      $req->bindParam(3, $score, PDO::PARAM_STR);
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
      $req = $this->getBdd()->prepare('SELECT id, pseudo, email, score, `psswrd` FROM players');
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
      $req = $this->getBdd()->prepare("SELECT id, pseudo, email, score, `psswrd` FROM players WHERE email = ? LIMIT 1");
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
