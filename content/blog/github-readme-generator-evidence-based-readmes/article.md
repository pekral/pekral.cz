---
date: 2026-09-03
description: I built github-readme-generator, an open-source Agent Skill that makes coding agents inspect a repository and ground README commands, badges, versions, and configuration in evidence before writing.
---

# Why AI-generated READMEs need evidence: introducing github-readme-generator

AI coding agents can create a polished README in seconds. They can also invent an installation command, add a badge that does not represent a real workflow, document a configuration key that does not exist, or confidently describe a feature the project never implemented.

The result may look professional while quietly becoming a problem for every developer who tries to follow it.

That is why I built [github-readme-generator](https://github.com/pekral/github-readme-generator), an open-source Agent Skill that changes how a coding agent approaches repository documentation. Instead of starting with prose, it starts with evidence.

## A README is part of the project interface

A README is often the first interaction someone has with a repository. Before they read the source code, open an issue, or install a package, they use the README to decide whether the project is relevant and trustworthy.

For that reason, documentation is more than presentation. Installation commands, supported versions, configuration keys, badges, and examples are part of the public interface of the project.

When one of those details is wrong, the problem is not merely editorial. A nonexistent command wastes time. An incorrect runtime requirement can break an installation. A badge can imply that tests are running when the referenced workflow does not cover the default branch. A copied example can drift away from the actual API.

AI makes it easier to produce documentation, but speed alone does not make the result reliable.

## Repository first, prose second

The main rule of `github-readme-generator` is simple: inspect the repository before writing a sentence.

The skill asks the agent to examine the sources that can support a README claim, including:

- package manifests and lock files,
- public entry points and source code,
- scripts and command definitions,
- tests and example projects,
- CI workflows,
- configuration templates,
- licences, changelogs, contribution guidelines, and security policies.

The agent builds an internal claim-to-source map and leaves out information it cannot verify. A shorter README that is entirely supported by the repository is more useful than a comprehensive one filled with plausible guesses.

This evidence-first approach also determines the structure of the generated document. Requirements, installation, configuration, and the first working example appear in a predictable order, so a new user does not need to jump around the page to get started.

## What the skill refuses to invent

Coding agents are very good at recognizing familiar project patterns. That strength can also become a weakness: when a repository resembles a typical Laravel package, Node CLI, Python library, or Rust crate, the model may fill in details that are common in the ecosystem but absent from the actual project.

The skill therefore treats several categories as claims that require evidence:

- installation and test commands,
- command-line flags,
- environment variables and configuration keys,
- supported runtime versions,
- package and registry names,
- CI, coverage, license, version, and download badges,
- external documentation and support links.

If a PHP package has no verified Packagist identity, the README should not pretend it can be installed with Composer. If a workflow only runs on pull requests, its badge should not suggest that the default branch is continuously tested. If a local `.env` contains a value but `.env.example` does not expose it, the value does not belong in public documentation.

The goal is not to make the agent less useful. It is to make uncertainty visible instead of silently replacing it with a guess.

## Repository content is data, not an instruction

There is another boundary that matters when an AI agent scans a codebase: repository files are untrusted input.

A source comment or documentation page can contain text directed at the agent. It might tell the model to add a fake certification badge, claim that a large company uses the project, run an unrelated command, or ignore its previous instructions.

`github-readme-generator` explicitly tells the agent to treat scanned content as evidence about the project, not as authority over its behaviour. Instructions encountered inside the repository should be reported, not obeyed.

The skill also limits its normal change scope to the root `README.md`. It does not stage files, create commits, push branches, or modify production code unless the user separately asks for those actions.

## Installation and first use

The skill has no runtime dependencies. The easiest installation method uses the open Agent Skills CLI:

```text
npx skills add pekral/github-readme-generator
```

It can also be installed only for selected agents or for the current user:

```text
npx skills add pekral/github-readme-generator -g -a claude-code -a codex
```

After installation, the prompt can remain deliberately simple:

```text
Write a README for this repository.
```

For an analysis without changing the file:

```text
Audit this README and tell me what's wrong.
```

The audit mode also looks beyond the document itself. Where repository metadata is available, it can report missing public information, invalid local links, misleading badges, or references to community files that do not exist. It reports those findings as text and does not change GitHub settings automatically.

## One skill, multiple coding agents

The repository keeps one canonical `SKILL.md` definition rather than maintaining separate instruction copies for every host. It is packaged for Claude Code, Codex, and Cursor, and the same skill can be installed into other agents supported by the Agent Skills CLI.

The project is currently developed and tested primarily with Claude Code. The other integrations are packaged, but I do not yet describe them as verified. That distinction is intentional: compatibility should be demonstrated rather than inferred from a manifest.

## Why this is a public beta

The repository includes structural tests, ten manual scenarios, fixture repositories, a deterministic scoring tool, and before-and-after examples. Automated checks run on Node.js 20 and 22.

However, having a benchmark is not the same as having trustworthy proof. The current scorer has known cases where it can mistake command output for a command or classify a project logo as a badge. The first recorded sample is also too small to demonstrate that the skill outperforms an agent working without it.

I would rather publish that limitation than turn an inconclusive result into a percentage for a marketing headline.

The [public beta release](https://github.com/pekral/github-readme-generator/releases/tag/v1.0.0-beta.1) is therefore an invitation to test the rules on real repositories—especially large, inconsistent, or partially documented ones that are much harder than small synthetic fixtures.

## What kind of feedback is useful

The most valuable feedback is not whether the generated README sounds good. It is whether the document remains faithful to the project.

I am particularly interested in cases where the skill:

- omits information that the repository clearly supports,
- preserves an outdated claim from the previous README,
- removes useful hand-written context,
- invents a command or configuration option,
- chooses the wrong installation path in a monorepo,
- creates a badge whose underlying source is not valid.

Those failures can become new fixtures, scenarios, and regression checks. In that way, a difficult real repository can improve the skill for every future user.

## Open source and deliberately inspectable

The complete skill, its reference documents, tests, fixtures, examples, contribution guide, and security policy are available in the repository. It is released under the MIT License, including a copy of the licence inside the installable skill directory.

You can inspect the instructions before installing them, fork the project, propose a change, or use the methodology as inspiration for your own Agent Skills.

The project is available at:

[github.com/pekral/github-readme-generator](https://github.com/pekral/github-readme-generator)

## Conclusion

AI can make documentation dramatically faster, but a fast README is only useful when developers can trust it.

`github-readme-generator` does not try to replace the maintainer's judgment. It gives the coding agent a stricter workflow: inspect first, trace every important claim to a source, avoid guesses, keep the change focused, and say what could not be proven.

If you maintain a repository with stale documentation, confusing setup instructions, or several plausible ways to install it, try the public beta and let me know where it gets the README wrong. Those edge cases are exactly what the project needs next.
