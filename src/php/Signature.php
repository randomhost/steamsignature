<?php

declare(strict_types=1);

namespace randomhost\Steam;

use randomhost\Image\Color;
use randomhost\Image\Image;
use randomhost\Image\Text\Generic as Text;
use randomhost\Steam\Dto\User\Profile;

/**
 * Main class for displaying the Steam status signature images.
 *
 * @author    Ch'Ih-Yu <chi-yu@web.de>
 * @copyright 2024 Random-Host.tv
 * @license   https://opensource.org/licenses/BSD-3-Clause  BSD License (3 Clause)
 *
 * @see https://github.random-host.tv
 */
class Signature
{
    /**
     * Full image directory path.
     *
     * @var string
     */
    protected $imageDir = '';

    /**
     * Full fonts directory path.
     *
     * @var string
     */
    protected $fontsDir = '';

    /**
     * Full cache directory path.
     *
     * @var string
     */
    protected $cacheDir = '';

    /**
     * Steam\ID object.
     *
     * @var Profile
     */
    protected $profile;

    /**
     * error code.
     *
     * @var int
     */
    protected $errorCode;

    /**
     * error message.
     *
     * @var string
     */
    protected $errorMessage;

    /**
     * Output image instance.
     *
     * @var Image
     */
    protected $outputImage;

    /**
     * Background image instance.
     *
     * @var Image
     */
    protected $backgroundImage;

    /**
     * Avatar image instance.
     *
     * @var Image
     */
    protected $avatarImage;

    /**
     * Box image instance.
     *
     * @var Image
     */
    protected $boxImage;

    /**
     * Connect image instance.
     *
     * @var Image
     */
    protected $connectImage;

    /**
     * Text color for rendering header texts.
     *
     * @var Color
     */
    protected $textColorHeader;

    /**
     * Text color for rendering content texts.
     *
     * @var Color
     */
    protected $textColorContent;

    /**
     * The x-ordinate for rendering texts.
     *
     * @var float
     */
    protected $textXPosition = 8.0;

    /**
     * The name of the box image which should be used.
     *
     * @var string
     */
    protected $boxImageName = '';

    /**
     * The header text to be rendered onto the image.
     *
     * @var string
     */
    protected $headerText = '';

    /**
     * The first line of text content to be rendered onto the image.
     *
     * @var string
     */
    protected $statusText1 = '';

    /**
     * The second line of text content to be rendered onto the image.
     *
     * @var string
     */
    protected $statusText2 = '';

    /**
     * Constructor for this class.
     *
     * @param API    $api      API instance.
     * @param string $id       A 64 bit Steam community ID.
     * @param string $imageDir Image directory.
     * @param string $fontsDir Fonts directory.
     * @param string $cacheDir Cache directory.
     *
     * @throws \Exception
     */
    public function __construct(API $api, string $id, string $imageDir, string $fontsDir, string $cacheDir)
    {
        $this->setImageDirectory($imageDir);
        $this->setFontsDirectory($fontsDir);
        $this->setCacheDirectory($cacheDir);

        try {
            $this->profile = new Profile(
                $api->fetchPlayerSummary($id)
            );
            $this->prepareData();
        } catch (\RuntimeException $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();

            $this->prepareErrorMessage();

            if ($api::ERROR_TIMEOUT === $this->errorCode) {
                $this->statusText1 = 'Couldn\'t connect to Steam';
                $this->statusText2 = 'Please try again later';
                trigger_error($this->errorMessage, E_USER_WARNING);
            } elseif (!empty($this->errorCode)) {
                $this->textXPosition = 48;
                $this->statusText1 = 'Please try again later';
                trigger_error($this->errorMessage, E_USER_WARNING);
            }
        } catch (\InvalidArgumentException $e) {
            $this->errorCode = $e->getCode();
            $this->errorMessage = $e->getMessage();

            $this->prepareErrorMessage();

            if ($api::ERROR_NOT_FOUND === $this->errorCode) {
                $this->statusText1 = 'Please check Steam ID';
            } elseif (!empty($this->errorCode)) {
                $this->textXPosition = 48;
                $this->statusText1 = 'Please try again later';
                trigger_error($this->errorMessage, E_USER_WARNING);
            }
        }
    }

    /**
     * Renders the picture.
     *
     * @throws \Exception
     */
    public function render(): void
    {
        // read background image
        $this->backgroundImage = Image::getInstanceByPath(
            $this->imageDir.'background.png'
        );

        // create output image
        $this->outputImage = Image::getInstanceByCreate(
            $this->backgroundImage->getWidth(),
            $this->backgroundImage->getHeight()
        );

        // insert background image
        $this->outputImage->merge($this->backgroundImage, 0, 0);

        unset($this->backgroundImage);

        // insert box image
        if (!empty($this->boxImageName)) {
            $this->boxImage = Image::getInstanceByPath(
                $this->imageDir.$this->boxImageName
            );

            $this->outputImage->merge($this->boxImage, 4, 4);

            unset($this->boxImage);
        }

        // insert avatar image
        try {
            if (!empty($this->profile)) {
                $this->avatarImage = Image::getInstanceByPath(
                    $this->profile->getDataUserGeneral()->getAvatar(),
                    $this->cacheDir
                );

                $this->outputImage->merge($this->avatarImage, 8, 8);

                unset($this->avatarImage);
            }
        } catch (\RuntimeException $e) {
            // avatar may be temporarily unavailable
            trigger_error($e->getMessage());
        }

        $text = new Text($this->outputImage);

        // set text rendering options for header
        $text->setTextFont($this->fontsDir.'DejaVuSans-Bold.ttf');
        $text->setTextColor($this->textColorHeader);
        $text->setTextSize(8.8);

        // insert header
        $text->insertText(
            $this->textXPosition,
            17,
            self::shortenText($this->headerText)
        );

        // set text rendering options for normal lines
        $text->setTextFont($this->fontsDir.'DejaVuSans.ttf');
        $text->setTextColor($this->textColorContent);
        $text->setTextSize(6.5);

        // insert status text line 1
        $text->insertText(
            $this->textXPosition,
            30,
            self::shortenText($this->statusText1)
        );

        // insert status text line 2
        $text->insertText(
            $this->textXPosition,
            41,
            self::shortenText($this->statusText2)
        );

        if (!empty($this->profile)
            && !$this->profile->getDataUserGeneral()->isPrivateProfile()
        ) {
            $game = $this->profile->getDataUserRestricted()->getGameData();

            // insert connect image
            if (!empty($game) && $game->isJoinable()) {
                $this->connectImage = Image::getInstanceByPath(
                    $this->imageDir.'connect.png'
                );

                $this->outputImage->merge(
                    $this->connectImage,
                    $this->outputImage->getWidth()
                    - $this->connectImage->getWidth(),
                    0
                );

                unset($this->connectImage);
            }
        }

        // display output image
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $cacheExpireDate = clone $now;
        $cacheExpireDate->modify('+ 5 minutes');

        $headers = [
            'Cache-Control: max-age='.($cacheExpireDate->getTimestamp() - $now->getTimestamp()),
            'Expires: '.$cacheExpireDate->format('D, d M Y H:i:s'),
            'Pragma: cache',
        ];

        foreach ($headers as $header) {
            header($header);
        }
        $this->outputImage->render();

        unset($this->outputImage);

        exit;
    }

    /**
     * Returns the link target.
     */
    public function getLinkTarget(): string
    {
        $url = $this->profile->getDataUserGeneral()->getProfileUrl();
        if (!$this->profile->getDataUserGeneral()->isPrivateProfile()) {
            $gameData = $this->profile->getDataUserRestricted()->getGameData();
            if (!empty($gameData)) {
                $connectUrl = $gameData->getConnectURL();
                if (!empty($connectUrl)) {
                    return $gameData->getConnectURL();
                }
            }
        }

        return $url;
    }

    /**
     * Shorten text to specified length. If a text is shortened, the string
     * '...' is appended at the end of the string.
     *
     * @param string $text  Text to be shortened.
     * @param int    $chars Maximum string length.
     */
    protected static function shortenText(string $text, int $chars = 40): string
    {
        if (mb_strlen($text) <= $chars) {
            return $text;
        }
        $text = $text.' ';
        $text = mb_substr($text, 0, $chars);
        $text = mb_substr($text, 0, mb_strrpos($text, ' '));

        return $text.'...';
    }

    /**
     * Parses the error code and fills the class properties accordingly.
     */
    protected function prepareErrorMessage(): void
    {
        $this->textColorHeader = new Color(238, 68, 68);
        $this->textColorContent = new Color(238, 68, 68);
        $this->textXPosition = 48;
        $this->boxImageName = 'box_error.png';
        $this->headerText = 'Error';
        $this->statusText1 = '';
        $this->statusText2 = '';
    }

    /**
     * Parses the XML feed and fills the class properties accordingly.
     */
    protected function prepareData(): void
    {
        $generalData = $this->profile->getDataUserGeneral();
        $restrictedData = $this->profile->getDataUserRestricted();

        if ($generalData->isPrivateProfile()) {
            $this->textColorHeader = new Color(137, 137, 137);
            $this->textColorContent = new Color(242, 108, 79);
            $this->textXPosition = 48;
            $this->boxImageName = 'box_offline.png';
            $this->headerText = $generalData->getDisplayName();
            $this->statusText1 = 'This profile is private.';
            $this->statusText2 = 'Online status not available.';
        } elseif (!empty($restrictedData)
            && !is_null($restrictedData->getGameData())
        ) {
            $gameData = $restrictedData->getGameData();
            $this->textColorHeader = new Color(177, 251, 80);
            $this->textColorContent = new Color(139, 197, 63);
            $this->textXPosition = 48;
            $this->boxImageName = 'box_ingame.png';
            $this->headerText = $generalData->getDisplayName();
            if ('' !== $gameData->getExtraInfo()) {
                $this->statusText1 = 'Playing '.$gameData->getExtraInfo();
                if ($gameData->isJoinable()) {
                    $this->statusText2 = $gameData->getServerIp();
                }
            } else {
                $this->statusText1 = 'In-Game';
            }
        } elseif ($generalData->isOnline()) {
            $this->textColorHeader = new Color(111, 189, 255);
            $this->textColorContent = new Color(98, 167, 227);
            $this->textXPosition = 48;
            $this->boxImageName = 'box_online.png';
            $this->headerText = $generalData->getDisplayName();
            $this->statusText1 = 'online';
        } else {
            $this->textColorHeader = new Color(137, 137, 137);
            $this->textColorContent = new Color(137, 137, 137);
            $this->textXPosition = 48;
            $this->boxImageName = 'box_offline.png';
            $this->headerText = $generalData->getDisplayName();
            $this->statusText1 = 'offline';
        }

        $this->headerText = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this->headerText);
    }

    /**
     * Sets the image directory path.
     *
     * @param string $imageDir Image directory path.
     */
    private function setImageDirectory(string $imageDir): void
    {
        if (!is_dir($imageDir)) {
            throw new \RuntimeException('Image directory not found');
        }

        if (!is_writable($imageDir)) {
            throw new \RuntimeException('Image directory is not readable');
        }

        $this->imageDir = $imageDir;
    }

    /**
     * Sets the fonts directory path.
     *
     * @param string $fontsDir Fonts directory path.
     */
    private function setFontsDirectory(string $fontsDir): void
    {
        if (!is_dir($fontsDir)) {
            throw new \RuntimeException('Fonts directory not found');
        }

        if (!is_writable($fontsDir)) {
            throw new \RuntimeException('Fonts directory is not readable');
        }

        $this->fontsDir = $fontsDir;
    }

    /**
     * Sets the cache directory path.
     *
     * @param string $cacheDir Cache directory path.
     */
    private function setCacheDirectory(string $cacheDir): void
    {
        if (!is_dir($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                throw new \RuntimeException('Failed to create cache directory');
            }

            if (!is_writable($cacheDir)) {
                throw new \RuntimeException('Cache directory is not writable');
            }
        }

        $this->cacheDir = $cacheDir;
    }
}
