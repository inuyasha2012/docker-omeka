<?php 
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 */
 
/**
 * @package Omeka
 * @subpackage Models
 * @author CHNM
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class Table_User extends Omeka_Db_Table
{
    /**
     * Find an active User given that user's ID.
     *
     * Returns null if the user being requested is not active.
     *
     * @return User|null
     */
    public function findActiveById($id)
    {
        $select = $this->getSelectForFind($id);
        $select->where('active = 1');
        return $this->fetchObject($select);
    }
    
    protected function _getColumnPairs()
    {
        return array(
            'users.id', 
            'users.name');
    }
    
    public function findByEmail($email)
    {
        $select = $this->getSelect();
        $select->where('users.email = ?')->limit(1);
        return $this->fetchObject($select, array($email));
    }
    
    public function applySearchFilters($select, $params)
    {
        // Show only users with a specific role.
        if (array_key_exists('role', $params) and !empty($params['role'])) {
            $select->where('users.role = ?', $params['role']);
        }
        
        // Show only users who are active
        if (array_key_exists('active', $params) and $params['active'] !== '') {
            $select->where('users.active = ?', (int)$params['active']);
        }
    }
}