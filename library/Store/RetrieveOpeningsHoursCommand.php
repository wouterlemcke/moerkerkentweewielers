<?php
class Store_RetrieveOpeningsHoursCommand extends Framework_Database_Command
{
	public function execute()
	{
		$connection = $this->getDatabaseConnection();
		$openingsHours = new Framework_Collection_Array();

		$result = $connection->query("
			select
			  ou.openingsurenid,
			  ou.dag,
			  ou.gesloten,
			  ou.openingstijd,
			  ou.sluitingstijd
			from
			  openingsuren ou");

		while ($record = $result->fetch_object())
		{
			$openingsHour = new Store_VisitingHours();
			$openingsHour->setDay($record->dag);

			if ($record->gesloten == 'Y')
			{
				$openingsHour->setClosedToday(true);
			}
			else
			{
				$openingsHour->setOpeningsTime(strtotime($record->openingstijd));
				$openingsHour->setClosingTime(strtotime($record->sluitingstijd));
			}

			$openingsHours->offsetSet($record->openingsurenid, $openingsHour);
		}

		return $openingsHours;
	}
}