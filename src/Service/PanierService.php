<?php

// src/Controller/EvenementController.php


namespace App\Service;

class PanierService
{
  private array $panier = [];

  public function addToPanier(int $id): void
  {
      if (!in_array($id, $this->panier, true)) {
          $this->panier[] = $id;
      }
  }

  public function removeFromPanier(int $id): void
  {
      $this->panier = array_filter($this->panier, fn($eventId) => $eventId !== $id);
  }

  public function getPanier(): array
  {
      return $this->panier;
  }
}
