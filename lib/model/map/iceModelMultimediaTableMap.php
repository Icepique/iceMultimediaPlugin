<?php



/**
 * This class defines the structure of the 'multimedia' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.plugins.iceMultimediaPlugin.lib.model.map
 */
class iceModelMultimediaTableMap extends TableMap
{

  /**
   * The (dot-path) name of this class
   */
  const CLASS_NAME = 'plugins.iceMultimediaPlugin.lib.model.map.iceModelMultimediaTableMap';

  /**
   * Initialize the table attributes, columns and validators
   * Relations are not initialized by this method since they are lazy loaded
   *
   * @return     void
   * @throws     PropelException
   */
  public function initialize()
  {
    // attributes
    $this->setName('multimedia');
    $this->setPhpName('iceModelMultimedia');
    $this->setClassname('iceModelMultimedia');
    $this->setPackage('plugins.iceMultimediaPlugin.lib.model');
    $this->setUseIdGenerator(true);
    // columns
    $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
    $this->addColumn('MODEL', 'Model', 'CHAR', true, 64, null);
    $this->addColumn('MODEL_ID', 'ModelId', 'INTEGER', false, null, null);
    $this->addColumn('TYPE', 'Type', 'CHAR', true, null, 'image');
    $this->addColumn('NAME', 'Name', 'CHAR', true, 128, null);
    $this->getColumn('NAME', false)->setPrimaryString(true);
    $this->addColumn('SLUG', 'Slug', 'CHAR', true, 128, null);
    $this->addColumn('MD5', 'Md5', 'CHAR', true, 32, null);
    $this->addColumn('SOURCE', 'Source', 'VARCHAR', false, 255, null);
    $this->addColumn('IS_PRIMARY', 'IsPrimary', 'BOOLEAN', false, 1, false);
    $this->addColumn('POSITION', 'Position', 'SMALLINT', false, null, 65535);
    $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
    // validators
  }

  /**
   * Build the RelationMap objects for this table relationships
   */
  public function buildRelations()
  {
  }

  /**
   *
   * Gets the list of behaviors registered for this table
   *
   * @return array Associative array (name => parameters) of behaviors
   */
  public function getBehaviors()
  {
    return array(
      'symfony' => array('form' => 'true', 'filter' => 'true', ),
      'symfony_behaviors' => array(),
      'symfony_timestampable' => array('create_column' => 'created_at', ),
      'alternative_coding_standards' => array('brackets_newline' => 'true', 'remove_closing_comments' => 'true', 'use_whitespace' => 'true', 'tab_size' => '2', 'strip_comments' => 'false', ),
    );
  }

}
