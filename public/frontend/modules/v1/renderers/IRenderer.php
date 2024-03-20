<?php

namespace frontend\modules\v1\renderers;

/**
 * Interface IRenderer
 * @package frontend\modules\v1\renderers
 */
interface IRenderer
{
    /**
     * Returns the generated response
     *
     * @return array
     */
    public function generateResponse(): array;
}