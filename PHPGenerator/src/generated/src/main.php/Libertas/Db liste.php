<?php declare(strict_types = 1);
namespace Libertas;

/**
 * @property-read \DB\Id $id lista
 * @property-read \DB\Id $id coalizione
 * @property-read \Libertas\Text $lista
 * @property-read \Libertas\Text $logo
 * @property-read \Libertas\Text $testo
 * @property-read \DB\TextOption $testo 2
 * @property-read \DB\Byte $stato
 * @property-read \DB\Byte $traduzione
 * @property-read \DB\Byte $id contenuto
 * @property-read \DB\Byte $workflow
 * @property-read \DB\Byte $id utente
 * @property-read \Libertas\DateTimeOption $data creazione
 * @property-read \Libertas\DateTimeOption $data aggiornamento
 * @property-read \Libertas\DateTimeOption $data pubblicazione
 * @property-read \Libertas\DateTimeOption $data newsletter
 * @property-read \Libertas\DateTimeOption $data decorrenza
 * @property-read \Libertas\DateTimeOption $data scadenza
 * @property-read \Libertas\Text $id lingua madre
 * @property-read \Libertas\Text $url parlante
 * @property-read \Libertas\Text $titolo
 * @property-read \DB\TextOption $descrizione
 * @property-read \DB\TextOption $parole chiave
 * @property-read \Libertas\Integer $sequenza
 */
class Db liste
extends \Type\AbstractRecord
{
	const FIELDS = [
		[ 'id lista', \DB\Id :: class ],
		[ 'id coalizione', \DB\Id :: class ],
		[ 'lista', \Libertas\Text :: class ],
		[ 'logo', \Libertas\Text :: class ],
		[ 'testo', \Libertas\Text :: class ],
		[ 'testo 2', \DB\TextOption :: class ],
		[ 'stato', \DB\Byte :: class ],
		[ 'traduzione', \DB\Byte :: class ],
		[ 'id contenuto', \DB\Byte :: class ],
		[ 'workflow', \DB\Byte :: class ],
		[ 'id utente', \DB\Byte :: class ],
		[ 'data creazione', \Libertas\DateTimeOption :: class ],
		[ 'data aggiornamento', \Libertas\DateTimeOption :: class ],
		[ 'data pubblicazione', \Libertas\DateTimeOption :: class ],
		[ 'data newsletter', \Libertas\DateTimeOption :: class ],
		[ 'data decorrenza', \Libertas\DateTimeOption :: class ],
		[ 'data scadenza', \Libertas\DateTimeOption :: class ],
		[ 'id lingua madre', \Libertas\Text :: class ],
		[ 'url parlante', \Libertas\Text :: class ],
		[ 'titolo', \Libertas\Text :: class ],
		[ 'descrizione', \DB\TextOption :: class ],
		[ 'parole chiave', \DB\TextOption :: class ],
		[ 'sequenza', \Libertas\Integer :: class ]
	];

	protected $id lista;
	protected $id coalizione;
	protected $lista;
	protected $logo;
	protected $testo;
	protected $testo 2;
	protected $stato;
	protected $traduzione;
	protected $id contenuto;
	protected $workflow;
	protected $id utente;
	protected $data creazione;
	protected $data aggiornamento;
	protected $data pubblicazione;
	protected $data newsletter;
	protected $data decorrenza;
	protected $data scadenza;
	protected $id lingua madre;
	protected $url parlante;
	protected $titolo;
	protected $descrizione;
	protected $parole chiave;
	protected $sequenza;

	public function __construct(
		\DB\Id $id lista,
		\DB\Id $id coalizione,
		\Libertas\Text $lista,
		\Libertas\Text $logo,
		\Libertas\Text $testo,
		\DB\TextOption $testo 2,
		\DB\Byte $stato,
		\DB\Byte $traduzione,
		\DB\Byte $id contenuto,
		\DB\Byte $workflow,
		\DB\Byte $id utente,
		\Libertas\DateTimeOption $data creazione,
		\Libertas\DateTimeOption $data aggiornamento,
		\Libertas\DateTimeOption $data pubblicazione,
		\Libertas\DateTimeOption $data newsletter,
		\Libertas\DateTimeOption $data decorrenza,
		\Libertas\DateTimeOption $data scadenza,
		\Libertas\Text $id lingua madre,
		\Libertas\Text $url parlante,
		\Libertas\Text $titolo,
		\DB\TextOption $descrizione,
		\DB\TextOption $parole chiave,
		\Libertas\Integer $sequenza)
	{
		$this->id lista = $id lista;
		$this->id coalizione = $id coalizione;
		$this->lista = $lista;
		$this->logo = $logo;
		$this->testo = $testo;
		$this->testo 2 = $testo 2;
		$this->stato = $stato;
		$this->traduzione = $traduzione;
		$this->id contenuto = $id contenuto;
		$this->workflow = $workflow;
		$this->id utente = $id utente;
		$this->data creazione = $data creazione;
		$this->data aggiornamento = $data aggiornamento;
		$this->data pubblicazione = $data pubblicazione;
		$this->data newsletter = $data newsletter;
		$this->data decorrenza = $data decorrenza;
		$this->data scadenza = $data scadenza;
		$this->id lingua madre = $id lingua madre;
		$this->url parlante = $url parlante;
		$this->titolo = $titolo;
		$this->descrizione = $descrizione;
		$this->parole chiave = $parole chiave;
		$this->sequenza = $sequenza;
	}

	public function __get($property)
	{
		if ( in_array( $property, [ 'id lista', 'id coalizione', 'lista', 'logo', 'testo', 'testo 2', 'stato', 'traduzione', 'id contenuto', 'workflow', 'id utente', 'data creazione', 'data aggiornamento', 'data pubblicazione', 'data newsletter', 'data decorrenza', 'data scadenza', 'id lingua madre', 'url parlante', 'titolo', 'descrizione', 'parole chiave', 'sequenza' ] ))
		{
			return $this->$property;
		}
		else
		{
			throw new \UnexpectedValueException( "Property $property does not exist" );
		}
	}

}
