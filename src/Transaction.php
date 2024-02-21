<?php
namespace App;

class Transaction
{
    private \DateTime $date;
    private string $concept;
    private float $amount;
    private float $saldo;

    public function getFechaOperacion(): \DateTime|string
    {
        if (null !== $this->date){
            return $this->date;
        }
        
        return 'not setted';
    }

    public function getConcepto(): string
    {
        if (null !== $this->concept){
            return $this->concept;
        }
        
        return 'not setted';
    }

    public function getImporte(): float|string
    {
        if (null !== $this->amount){
            return $this->amount;
        }
        
        return 'not setted';
    }

    public function getSaldo(): float|string
    {
        if (null !== $this->saldo){
            return $this->saldo;
        }
        
        return 'not setted';
    }

    public function setFechaOperacion(\DateTime $date): Transaction
    {
        $this->date = $date;
        return $this;
    }
    public function setConcepto (int $concept): Transaction
    {
        $this->concept = $concept;
        return $this;
    }
    public function setImporte (int $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }
    public function setSaldo (int $saldo): Transaction
    {
        $this->saldo = $saldo;
        return $this;
    }
}