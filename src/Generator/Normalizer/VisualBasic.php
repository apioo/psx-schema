<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Schema\Generator\Normalizer;

/**
 * VisualBasic
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class VisualBasic extends NormalizerAbstract
{
    protected function getPropertyStyle(): int
    {
        return self::PASCAL_CASE;
    }

    protected function hasPropertyReserved(): bool
    {
        return false;
    }

    protected function getKeywords(): array
    {
        return [
            'AddHandler',
            'AddressOf',
            'Alias',
            'And',
            'AndAlso',
            'As',
            'Boolean',
            'ByRef',
            'Byte',
            'ByVal',
            'Call',
            'Case',
            'Catch',
            'CBool',
            'CByte',
            'CChar',
            'CDate',
            'CDbl',
            'CDec',
            'Char',
            'CInt',
            'Class',
            'CLng',
            'CObj',
            'Const',
            'Continue',
            'CSByte',
            'CShort',
            'CSng',
            'CStr',
            'CType',
            'CUInt',
            'CULng',
            'CUShort',
            'Date',
            'Decimal',
            'Declare',
            'Default',
            'Delegate',
            'Dim',
            'DirectCast',
            'Do',
            'Double',
            'Each',
            'Else',
            'ElseIf',
            'End',
            'EndIf',
            'Enum',
            'Erase',
            'Error',
            'Event',
            'Exit',
            'False',
            'Finally',
            'For',
            'Friend',
            'Function',
            'Get',
            'GetType',
            'GetXMLNamespace',
            'Global',
            'GoSub',
            'GoTo',
            'Handles',
            'If',
            'Implements',
            'Imports',
            'In',
            'Inherits',
            'Integer',
            'Interface',
            'Is',
            'IsNot',
            'Let',
            'Lib',
            'Like',
            'Long',
            'Loop',
            'Me',
            'Mod',
            'Module',
            'MustInherit',
            'MustOverride',
            'MyBase',
            'MyClass',
            'NameOf',
            'Namespace',
            'Narrowing',
            'New',
            'Next',
            'Not',
            'Nothing',
            'NotInheritable',
            'NotOverridable',
            'Object',
            'Of',
            'On',
            'Operator',
            'Option',
            'Optional',
            'Or',
            'OrElse',
            'Out',
            'Overloads',
            'Overridable',
            'Overrides',
            'ParamArray',
            'Partial',
            'Private',
            'Property',
            'Protected',
            'Public',
            'RaiseEvent',
            'ReadOnly',
            'ReDim',
            'REM',
            'RemoveHandler',
            'Resume',
            'Return',
            'SByte',
            'Select',
            'Set',
            'Shadows',
            'Shared',
            'Short',
            'Single',
            'Static',
            'Step',
            'Stop',
            'String',
            'Structure',
            'Sub',
            'SyncLock',
            'Then',
            'Throw',
            'To',
            'True',
            'Try',
            'TryCast',
            'TypeOf',
            'UInteger',
            'ULong',
            'UShort',
            'Using',
            'Variant',
            'Wend',
            'When',
            'While',
            'Widening',
            'With',
            'WithEvents',
            'WriteOnly',
            'Xor',
        ];
    }
}
