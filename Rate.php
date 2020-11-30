<?php

class Rate extends Model
{

    public static function getRateByDate($date)
    {
        $db = Db::getConnection();

        $exchangeRate = array();

        $sql = "SELECT USD, EUR FROM exchange_rate WHERE date=STR_TO_DATE(:date, '%Y-%m-%d')";

        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->execute();

        $i = 0;
        while ($row = $result->fetch()) {
            $exchangeRate['USD'] = $row['USD'];
            $exchangeRate['EUR'] = $row['EUR'];
            $i++;
        }

        return $exchangeRate;
    }

    public static function addRateByDate($USD, $EUR, $date)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO exchange_rate (USD, EUR, date) VALUES (:USD, :EUR, STR_TO_DATE(:date, '%Y-%m-%d'))";

        $result = $db->prepare($sql);
        $result->bindParam(':USD', $USD, PDO::PARAM_STR);
        $result->bindParam(':EUR', $EUR, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);

        return $result->execute();
    }
}
