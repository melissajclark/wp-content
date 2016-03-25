<?php

class PriorityQueueInsertionOrder extends SplPriorityQueue
{
	protected $counter;

	public function __construct()
    {
		// parent::__construct(); // WTF fatal error.
		$this->counter = PHP_INT_MAX;
	}

	public function insert( $value, $priority )
    {
		if ( is_int( $priority ) ) {
            $priority = array( $priority, --$this->counter );
        }
		parent::insert( $value, $priority );
	}

	public function remove( $value )
    {
		$new_queue = new self;
		$new_queue->setExtractFlags( SplPriorityQueue ::EXTR_BOTH );

		$this->setExtractFlags( SplPriorityQueue ::EXTR_BOTH );

		// Since there isn't a remove method on the SplPriorityQueue class, I have to do it myself.
		// I'm using a temporary queue to hold everything except what I want to remove, then I insert it back into $this.
		// (remember that items are extracted when iterated)

		foreach ( $this as $entry ) {
			if( $value == $entry['data'] )
				continue;
			$new_queue->insert( $entry['data'], $entry['priority'] );
		}

		foreach ( $new_queue as $entry )
			$this->insert( $entry['data'], $entry['priority'] );

		$this->setExtractFlags( SplPriorityQueue ::EXTR_DATA );
	}

}
