<?php

/*
 * Copyright 2006-2011 Florent Paillard
 * 
 * This file is part of /kal.ku.'li/.
 * 
 * /kal.ku.'li/ is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * /kal.ku.'li/ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with /kal.ku.'li/.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */



/**
 * Skeleton subclass for representing a row from the 'outgoing' table.
 *
 * What is consumed by the community
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classes
 */
class Outgoing extends BaseOutgoing {

	public function computeWeightedPart() {
		return -$this->getOutWeight() * $this->getOperation()->computePart();
	}
	
	public function getOperationTS() {
		return $this->getOperation()->getOperationTS(DATE_FORMAT);
	}
	
	public function getOperationDescription() {
		return $this->getOperation()->getOperationDescription();
	}
	
	public function getOperationTotalInAmount() {
		return $this->getOperation()->getTotalInAmount();
	}
	
	public function getOperationTotalOutWeight() {
		return $this->getOperation()->getTotalOutWeight();
	}
	
	public function getPersonName() {
		return $this->getPerson()->getPersonName();
	}
	
	public function getPersonId() {
		return $this->getPerson()->getPersonId();
	}

} // Outgoing
