<?php

namespace CustomHook\PreCommitHook;

use Composer\Script\Event;

class Hook
{
    private static $rule_set_dir = '$PROJECT/hook-install/';

    public function __construct() {

    }

    public static function run(Event $event) {
        // Get Remote URL
        $remote_host       = isset($event->getComposer()->getConfig()->get('rule_set_info')['remote_url'])
                ? $event->getComposer()->getConfig()->get('rule_set_info')['remote_url']
                : '';
        // Get PHP CS ruleset
        $phpcs_rule_set    = isset($event->getComposer()->getConfig()->get('rule_set_info')['phpcs_rule_set'])
                ? $event->getComposer()->getConfig()->get('rule_set_info')['phpcs_rule_set']
                : '';
        // Get PHP MD ruleset
        $phpmd_rule_set    = isset($event->getComposer()->getConfig()->get('rule_set_info')['phpmd_rule_set'])
                ? $event->getComposer()->getConfig()->get('rule_set_info')['phpmd_rule_set']
                : '';
        // Get PHP MD exclude directory
        $phpmd_exclude_dir = isset($event->getComposer()->getConfig()->get('rule_set_info')['phpmd_exclude_dir'])
                ? $event->getComposer()->getConfig()->get('rule_set_info')['phpmd_exclude_dir']
                : '';
        // Get PHP CS exclude directory
        $phpcs_exclude_dir = isset($event->getComposer()->getConfig()->get('rule_set_info')['phpcs_exclude_dir'])
                ? $event->getComposer()->getConfig()->get('rule_set_info')['phpcs_exclude_dir']
                : '';
        // Check remote URL exists or not
        $file_headers      = @get_headers($remote_host);
        if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            exit();
        } else {
            if (!empty($remote_host) && !empty($phpcs_rule_set) && !empty($phpmd_rule_set)) {
                // Set rult set directory
                $target_dir      = getcwd().DIRECTORY_SEPARATOR.'.git'.DIRECTORY_SEPARATOR.'hooks';
                // Get pre commit hook from server
                $pre_commit_hook = file_get_contents($remote_host.'git-hook/pre-commit');
                // Replace remote host in pre-hook file
                $pre_commit_hook = str_replace(
                    '[RULE-REMOTE-HOST]', $remote_host, $pre_commit_hook
                );
                // Replace PHP CS ruleset in pre-hook file
                $pre_commit_hook = str_replace(
                    '[RULE-SET-CS]', $phpcs_rule_set, $pre_commit_hook
                );
                // Replace PHP MD ruleset in pre-hook file
                $pre_commit_hook = str_replace(
                    '[RULE-SET-MESS-DETECTOR]', $phpmd_rule_set,
                    $pre_commit_hook
                );
                // Replace ruleset directory in pre-hook file
                $pre_commit_hook = str_replace(
                    '[RULE_SET_DIR]', self::$rule_set_dir, $pre_commit_hook
                );
                // Set PHP MD exclude directory
                $pre_commit_hook = str_replace(
                    '[PHPMD_EXCLUDE_DIR]', $phpmd_exclude_dir, $pre_commit_hook
                );
                // Set PHP CS exclude directory
                $pre_commit_hook = str_replace(
                    '[PHPCS_EXCLUDE_DIR]',$phpcs_exclude_dir, $pre_commit_hook
                );
                // Save pre-commit hook
                file_put_contents(
                    __DIR__.DIRECTORY_SEPARATOR.'pre-commit', $pre_commit_hook
                );
                // Save phpcs ruleset
                $phpcs_rule_file = file_get_contents($remote_host.'phpcs.ruleset.xml');
                file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'phpcs.ruleset.xml',
                    $phpcs_rule_file);

                // Save phpmd ruleset
                $phpmd_rule_file = file_get_contents($remote_host.'phpmd.ruleset.xml');
                file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'phpmd.ruleset.xml',
                    $phpmd_rule_file);

                // Copy pre-commit hook to git directory
                copy(
                    __DIR__.DIRECTORY_SEPARATOR.'pre-commit',
                    $target_dir.DIRECTORY_SEPARATOR.'pre-commit'
                );
                // Change pre-commit hook permission
                chmod($target_dir.DIRECTORY_SEPARATOR.'pre-commit', 0775);
            }
        }
    }
}