from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .map import Map
from .human_type import HumanType
from .student import Student


class StudentMap(Map[HumanType, Student]):
    pass


