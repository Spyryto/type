<?php declare(strict_types = 1);
namespace Libertas;

/**
 * @property-read \DB\Id $id rel
 * @property-read \DB\Id $id categoria
 * @property-read \DB\Id $id contenuto
 * @property-read \DB\Id $id tema
 */
class Chan db articoli Rimini
extends \Type\AbstractRecord
{
	const FIELDS = [
		[ 'id rel', \DB\Id :: class ],
		[ 'id categoria', \DB\Id :: class ],
		[ 'id contenuto', \DB\Id :: class ],
		[ 'id tema', \DB\Id :: class ]
	];

	protected $id rel;
	protected $id categoria;
	protected $id contenuto;
	protected $id tema;

	public function __construct(
		\DB\Id $id rel,
		\DB\Id $id categoria,
		\DB\Id $id contenuto,
		\DB\Id $id tema)
	{
		$this->id rel = $id rel;
		$this->id categoria = $id categoria;
		$this->id contenuto = $id contenuto;
		$this->id tema = $id tema;
	}

	public function __get($property)
	{
		if ( in_array( $property, [ 'id rel', 'id categoria', 'id contenuto', 'id tema' ] ))
		{
			return $this->$property;
		}
		else
		{
			throw new \UnexpectedValueException( "Property $property does not exist" );
		}
	}

}
