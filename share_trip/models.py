from django.conf import settings
from django.db import models
from django.utils import timezone


class Itinerary(models.Model):

    title = models.CharField(max_length=32)
    comment = models.TextField()
    author = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    created_date = models.DateTimeField(default=timezone.now)
    edited_date = models.DateTimeField(blank=True, null=True)

    def plan(self):
        self.save()

    def __str__(self):
        return self.title