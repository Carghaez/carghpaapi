<?php
/*
 * Copyright 2016 Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */

namespace CarghPAAPI\Operations;

/**
 * A browse node lookup operation
 *
 * @see    http://docs.aws.amazon.com/AWSECommerceService/latest/DG/BrowseNodeLookup.html
 * @author Gaetano Carpinato <gaetanocarpinato@gmail.com>
 */
class BrowseNodeLookup extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'BrowseNodeLookup';
    }

    /**
     * Returns the nodeid
     *
     * @return string
     */
    public function getNodeId()
    {
        return $this->getSingleOperationParameter('BrowseNodeId');
    }

    /**
     * Sets the nodeid in which should be looked up
     *
     * @param string $nodeId
     *
     * @return \CarghPAAPI\Operations\BrowseNodeLookup
     */
    public function setNodeId($nodeId)
    {
        $this->parameters['BrowseNodeId'] = $nodeId;
        return $this;
    }
}
