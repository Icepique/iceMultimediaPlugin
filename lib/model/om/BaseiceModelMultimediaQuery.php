<?php


/**
 * Base class that represents a query for the 'multimedia' table.
 *
 * 
 *
 * @method     iceModelMultimediaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     iceModelMultimediaQuery orderByModel($order = Criteria::ASC) Order by the model column
 * @method     iceModelMultimediaQuery orderByModelId($order = Criteria::ASC) Order by the model_id column
 * @method     iceModelMultimediaQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     iceModelMultimediaQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     iceModelMultimediaQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method     iceModelMultimediaQuery orderByMd5($order = Criteria::ASC) Order by the md5 column
 * @method     iceModelMultimediaQuery orderBySource($order = Criteria::ASC) Order by the source column
 * @method     iceModelMultimediaQuery orderByIsPrimary($order = Criteria::ASC) Order by the is_primary column
 * @method     iceModelMultimediaQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     iceModelMultimediaQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     iceModelMultimediaQuery groupById() Group by the id column
 * @method     iceModelMultimediaQuery groupByModel() Group by the model column
 * @method     iceModelMultimediaQuery groupByModelId() Group by the model_id column
 * @method     iceModelMultimediaQuery groupByType() Group by the type column
 * @method     iceModelMultimediaQuery groupByName() Group by the name column
 * @method     iceModelMultimediaQuery groupBySlug() Group by the slug column
 * @method     iceModelMultimediaQuery groupByMd5() Group by the md5 column
 * @method     iceModelMultimediaQuery groupBySource() Group by the source column
 * @method     iceModelMultimediaQuery groupByIsPrimary() Group by the is_primary column
 * @method     iceModelMultimediaQuery groupByPosition() Group by the position column
 * @method     iceModelMultimediaQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     iceModelMultimediaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     iceModelMultimediaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     iceModelMultimediaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     iceModelMultimedia findOne(PropelPDO $con = null) Return the first iceModelMultimedia matching the query
 * @method     iceModelMultimedia findOneOrCreate(PropelPDO $con = null) Return the first iceModelMultimedia matching the query, or a new iceModelMultimedia object populated from the query conditions when no match is found
 *
 * @method     iceModelMultimedia findOneById(int $id) Return the first iceModelMultimedia filtered by the id column
 * @method     iceModelMultimedia findOneByModel(string $model) Return the first iceModelMultimedia filtered by the model column
 * @method     iceModelMultimedia findOneByModelId(int $model_id) Return the first iceModelMultimedia filtered by the model_id column
 * @method     iceModelMultimedia findOneByType(string $type) Return the first iceModelMultimedia filtered by the type column
 * @method     iceModelMultimedia findOneByName(string $name) Return the first iceModelMultimedia filtered by the name column
 * @method     iceModelMultimedia findOneBySlug(string $slug) Return the first iceModelMultimedia filtered by the slug column
 * @method     iceModelMultimedia findOneByMd5(string $md5) Return the first iceModelMultimedia filtered by the md5 column
 * @method     iceModelMultimedia findOneBySource(string $source) Return the first iceModelMultimedia filtered by the source column
 * @method     iceModelMultimedia findOneByIsPrimary(boolean $is_primary) Return the first iceModelMultimedia filtered by the is_primary column
 * @method     iceModelMultimedia findOneByPosition(int $position) Return the first iceModelMultimedia filtered by the position column
 * @method     iceModelMultimedia findOneByCreatedAt(string $created_at) Return the first iceModelMultimedia filtered by the created_at column
 *
 * @method     array findById(int $id) Return iceModelMultimedia objects filtered by the id column
 * @method     array findByModel(string $model) Return iceModelMultimedia objects filtered by the model column
 * @method     array findByModelId(int $model_id) Return iceModelMultimedia objects filtered by the model_id column
 * @method     array findByType(string $type) Return iceModelMultimedia objects filtered by the type column
 * @method     array findByName(string $name) Return iceModelMultimedia objects filtered by the name column
 * @method     array findBySlug(string $slug) Return iceModelMultimedia objects filtered by the slug column
 * @method     array findByMd5(string $md5) Return iceModelMultimedia objects filtered by the md5 column
 * @method     array findBySource(string $source) Return iceModelMultimedia objects filtered by the source column
 * @method     array findByIsPrimary(boolean $is_primary) Return iceModelMultimedia objects filtered by the is_primary column
 * @method     array findByPosition(int $position) Return iceModelMultimedia objects filtered by the position column
 * @method     array findByCreatedAt(string $created_at) Return iceModelMultimedia objects filtered by the created_at column
 *
 * @package    propel.generator.plugins.iceMultimediaPlugin.lib.model.om
 */
abstract class BaseiceModelMultimediaQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of BaseiceModelMultimediaQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'propel', $modelName = 'iceModelMultimedia', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new iceModelMultimediaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return    iceModelMultimediaQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof iceModelMultimediaQuery) {
            return $criteria;
        }
        $query = new iceModelMultimediaQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }
        return $query;
    }

    /**
     * Find object by primary key
     * Use instance pooling to avoid a database query if the object exists
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return    iceModelMultimedia|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ((null !== ($obj = iceModelMultimediaPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
            // the object is alredy in the instance pool
            return $obj;
        } else {
            // the object has not been requested yet, or the formatter is not an object formatter
            $criteria = $this->isKeepQuery() ? clone $this : $this;
            $stmt = $criteria
                ->filterByPrimaryKey($key)
                ->getSelectStatement($con);
            return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
        }
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        return $this
            ->filterByPrimaryKeys($keys)
            ->find($con);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(iceModelMultimediaPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(iceModelMultimediaPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the model column
     *
     * Example usage:
     * <code>
     * $query->filterByModel('fooValue');   // WHERE model = 'fooValue'
     * $query->filterByModel('%fooValue%'); // WHERE model LIKE '%fooValue%'
     * </code>
     *
     * @param     string $model The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByModel($model = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($model)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $model)) {
                $model = str_replace('*', '%', $model);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::MODEL, $model, $comparison);
    }

    /**
     * Filter the query on the model_id column
     *
     * Example usage:
     * <code>
     * $query->filterByModelId(1234); // WHERE model_id = 1234
     * $query->filterByModelId(array(12, 34)); // WHERE model_id IN (12, 34)
     * $query->filterByModelId(array('min' => 12)); // WHERE model_id > 12
     * </code>
     *
     * @param     mixed $modelId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByModelId($modelId = null, $comparison = null)
    {
        if (is_array($modelId)) {
            $useMinMax = false;
            if (isset($modelId['min'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::MODEL_ID, $modelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modelId['max'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::MODEL_ID, $modelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::MODEL_ID, $modelId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::SLUG, $slug, $comparison);
    }

    /**
     * Filter the query on the md5 column
     *
     * Example usage:
     * <code>
     * $query->filterByMd5('fooValue');   // WHERE md5 = 'fooValue'
     * $query->filterByMd5('%fooValue%'); // WHERE md5 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $md5 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByMd5($md5 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($md5)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $md5)) {
                $md5 = str_replace('*', '%', $md5);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::MD5, $md5, $comparison);
    }

    /**
     * Filter the query on the source column
     *
     * Example usage:
     * <code>
     * $query->filterBySource('fooValue');   // WHERE source = 'fooValue'
     * $query->filterBySource('%fooValue%'); // WHERE source LIKE '%fooValue%'
     * </code>
     *
     * @param     string $source The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($source)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $source)) {
                $source = str_replace('*', '%', $source);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::SOURCE, $source, $comparison);
    }

    /**
     * Filter the query on the is_primary column
     *
     * Example usage:
     * <code>
     * $query->filterByIsPrimary(true); // WHERE is_primary = true
     * $query->filterByIsPrimary('yes'); // WHERE is_primary = true
     * </code>
     *
     * @param     boolean|string $isPrimary The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByIsPrimary($isPrimary = null, $comparison = null)
    {
        if (is_string($isPrimary)) {
            $is_primary = in_array(strtolower($isPrimary), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::IS_PRIMARY, $isPrimary, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(iceModelMultimediaPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(iceModelMultimediaPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param     iceModelMultimedia $iceModelMultimedia Object to remove from the list of results
     *
     * @return    iceModelMultimediaQuery The current query, for fluid interface
     */
    public function prune($iceModelMultimedia = null)
    {
        if ($iceModelMultimedia) {
            $this->addUsingAlias(iceModelMultimediaPeer::ID, $iceModelMultimedia->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}