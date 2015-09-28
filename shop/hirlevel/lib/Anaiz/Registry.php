<?php

/**
 * Registry is a static class used to store and retrieve Resources that need to be available site-wide.
 */
class Registry {

    protected static $registry = array();
    protected static $locked = false;

    /**
     * Stores an object in the Registry, under a given id. If the id is already registered, an Exception is thrown.
     * @param string    $id         Unique identifier.
     * @param Object    $resource   Resource object.
     */
    public static function add($id, $resource) {
        if (!self::isLocked()) {
            if (!self::exists($id)) {
                self::$registry[$id] = $resource;
            } else {
                throw new Exception('Failed to add resource to Registry: resource already exists. ResourceId = \'' . $id . '\'');
            }
        } else {
            throw new Exception('Failed to add resource to Registry: Registry is locked. ResourceId = \'' . $id . '\'');
        }
    }

    /**
     * Removes an object from the Registry, and returns true on success. If the object with the given id does not exist, false is returned.
     * @param string    $id Unique identifier.
     * @return boolean
     */
    public static function remove($id) {
        if (!self::isLocked()) {
            if (self::exists($id)) {
                unset(self::$registry[$id]);
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception('Failed to remove resource from Registry: Registry is locked. ResourceId = \'' . $id . '\'');
        }
    }

    /**
     * Retrieves an object from the Registry. If the provided resource identifier is not found in the Registry, an Exception is thrown.
     * @param string    $id Unuique identifier.
     * @return Object
     */
    public static function get($id) {
        if (self::exists($id)) {
            return self::$registry[$id];
        } else {
            throw new Exception('Invalid resource requested from Registry. ResourceId = \'' . $id . '\'');
        }
    }

    /**
     * Returns true if there is an object stored in the Registry with the provided identifier. Returns false if the identifier is not found.
     * @param string    $id Unique identifier.
     * @return boolean
     */
    public static function exists($id) {
        return isset(self::$registry[$id]);
    }

    /**
     * Returns true if the Registry is locked. Once the registry has been locked, all add() and remove() oprations will fail with throwing an Exception.
     * @return boolean
     */
    public static function isLocked() {
        return self::$locked;
    }

    /**
     * Locks the Registry. When the Registry is locked, all add() and remove() oprations will fail with throwing an Exception. Once locked, the Registry cannot be unlocked.
     */
    public static function lock() {
        self::$locked = true;
    }

}
