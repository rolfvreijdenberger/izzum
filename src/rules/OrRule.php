<?php
namespace izzum\rules;

/**
 * When a rule is chained using the 'OR' operator only one of the rules given in
 * the
 * constructor needs to apply.
 *
 * $rule = new True();
 * $chained = $rule->orRule(new False());
 * $chained->applies();//true, since true or false is true.
 * 
 * @author Rolf Vreijdenberger
 * @author Richard Ruiter
 */
class OrRule extends Rule {
    /**
     *
     * @var izzum\rules\Rule
     */
    private $original;
    /**
     *
     * @var izzum\rules\Rule
     */
    private $other;

    /**
     *
     * @param \izzum\rules\Rule $original            
     * @param \izzum\rules\Rule $other            
     */
    public function __construct(Rule $original, Rule $other)
    {
        $this->original = $original;
        $this->other = $other;
    }

    public function _applies()
    {
        return (boolean) $this->original->applies() || $this->other->applies();
    }

    /**
     *
     * @return string
     */
    public function toString()
    {
        // includes the namespace
        $original = $this->original->toString();
        $other = $this->other->toString();
        return "($original or $other)";
    }

    /**
     * Merge results
     *
     * @return array
     */
    public function getResults()
    {
        return array_merge($this->other->getResults(), $this->original->getResults());
    }
}