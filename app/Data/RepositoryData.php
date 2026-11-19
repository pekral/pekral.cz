<?php

declare(strict_types = 1);

namespace App\Data;

/**
 * @phpstan-type RepositoryArray array{name: string, description: string, url: string, language: string, composerDescription: string, phpVersion: string, stars: int, topics: list<string>}
 */
final readonly class RepositoryData
{

    /**
     * @param list<string> $topics
     */
    public function __construct(
        public string $name,
        public string $description,
        public string $url,
        public string $language,
        public string $composerDescription,
        public string $phpVersion,
        public int $stars,
        public array $topics,
    ) {}

    /**
     * @param RepositoryArray $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            url: $data['url'],
            language: $data['language'],
            composerDescription: $data['composerDescription'],
            phpVersion: $data['phpVersion'],
            stars: $data['stars'],
            topics: $data['topics'],
        );
    }

    /**
     * @return RepositoryArray
     */
    public function toArray(): array
    {
        return [
            'composerDescription' => $this->composerDescription,
            'description' => $this->description,
            'language' => $this->language,
            'name' => $this->name,
            'phpVersion' => $this->phpVersion,
            'stars' => $this->stars,
            'topics' => $this->topics,
            'url' => $this->url,
        ];
    }

    public function summary(): string
    {
        return filled($this->description) ? $this->description : $this->composerDescription;
    }

    public function hasDistinctComposerDescription(): bool
    {
        return filled($this->composerDescription) && $this->composerDescription !== $this->description;
    }

}
